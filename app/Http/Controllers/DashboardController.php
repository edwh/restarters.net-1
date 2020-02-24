<?php

namespace App\Http\Controllers;

use App\Device;
use App\EventsUsers;
use App\Group;
use App\Helpers\CachingRssRetriever;
use App\Helpers\CachingWikiPageRetriever;
use App\Helpers\FixometerHelper;
use App\Party;
use App\User;
use App\UserGroups;
use App\UsersSkills;
use Illuminate\Support\Str;
use Auth;
use Cache;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::getProfile(Auth::id());

        // Update language every time you go to the dashboard
        Auth::user()->update([
            'language' => session('locale'),
        ]);

        $in_group = ! empty(UserGroups::where('user', Auth::id())->get()->toArray());

        //See whether user has any groups
        if ($in_group) {
            $group_ids = UserGroups::where('user', Auth::id())->pluck('group')->toArray();
        }

        $groupsNearYou = null;
        if ($in_group) {
            $all_groups = Group::whereIn('idgroups', $group_ids)->get();
        } else {
            $groupsNearYou = $user->groupsNearby(150, 3);
        }

        if ( ! isset($all_groups) || empty($all_groups->toArray())) {
            $all_groups = null;
        }

        // Get events nearest (or not) to you
        // Should the user have location info
        $upcoming_events = Party::withAll()
        ->upcomingEvents()
        ->where('users_groups.user', $user->id)
        ->when($user->hasLocationSet(), function($query) {
            return $query->havingDistanceWithin(40); // 24 miles
        })
        ->orderBy('event_date', 'ASC')
        ->orderBy('start', 'ASC')
        ->when($user->hasLocationSet(), function($query) {
            return $query->orderBy('distance', 'ASC');
        })
        ->take(3)
        ->get();

        $user_upcoming_events = Party::withAll()
        ->upcomingEvents()
        ->whereHas('users', function($query) use($user) {
          return $query->where('user', $user->id);
        })
        ->where('users_groups.user', $user->id)
        ->orderBy('event_date', 'ASC')
        ->orderBy('start', 'ASC')
        ->take(3)
        ->get();

        $rssRetriever = new CachingRssRetriever('https://therestartproject.org/feed');
        $news_feed = $rssRetriever->getRSSFeed(3);

        $wikiPagesRetriever = new CachingWikiPageRetriever(env('WIKI_URL').'/api.php');
        $wiki_pages = $wikiPagesRetriever->getRandomWikiPages(5);

        //Show onboarding modals on first login
        if ($user->number_of_logins == 1) {
            $onboarding = true;
        } else {
            $onboarding = false;
        }

        $devices_gateway = new Device;
        $impact_stats = $devices_gateway->getWeights();

        // 'Newly added' CTA
        // Logic includes new groups within 20 miles of the user's location
        // (if set) within the last month.
        $new_groups = Group::createdWithinLastMonth()
        ->when($user->hasLocationSet(), function($query) {
          return $query->havingDistanceWithin(32.1869); // 20 miles
        })
        ->orderBy('idgroups', 'DESC')
        ->get();

        $user_groups = Group::with('allRestarters', 'parties', 'groupImage.image')
        ->join('users_groups', 'users_groups.group', '=', 'groups.idgroups')
        ->join('events', 'events.group', '=', 'groups.idgroups')
        ->where('users_groups.user', $user->id)
        ->orderBy('groups.name', 'ASC')
        ->groupBy('groups.idgroups')
        ->select('groups.*')
        ->get();

        $owned_groups = Group::with('allHosts')
        ->whereHas('allHosts', function($query) use($user) {
          return $query->where('user', $user->id);
        })
        ->join('users_groups', 'users_groups.group', '=', 'groups.idgroups')
        ->where('users_groups.user', $user->id)
        ->orderBy('groups.name', 'ASC')
        ->groupBy('groups.idgroups')
        ->select('groups.*')
        ->get();

        return view('dashboard.index', [
            'gmaps' => true,
            'user' => $user,
            'header' => true,
            'groupsNearYou' => $groupsNearYou,
            'past_events' => $past_events,
            'upcoming_events' => $upcoming_events,
            'user_upcoming_events' => $user_upcoming_events,
            'outdated_groups' => $outdated_groups,
            'inactive_groups' => $inactive_groups,
            'news_feed' => $news_feed,
            'all_groups' => $all_groups,
            'new_groups' => $new_groups,
            'user_groups' => $user_groups,
            'owned_groups' => $owned_groups,
            'onboarding' => $onboarding,
            'impact_stats' => $impact_stats,
            'wiki_pages' => $wiki_pages,
            'hot_topics' => $this->getDiscourseHotTopics(),
        ]);
    }

    public function getDiscourseHotTopics()
    {

        /**
         * Query Discourse API for current logged in user
         * This retrieves all categories from Discourse
         */
        if (Cache::has('talk_categories_'.Auth::user()->username)) {
            $talk_categories = Cache::get('talk_categories_'.Auth::user()->username);
        } else {
            $talk_categories = [];
            $talk_categories_json = FixometerHelper::discourseAPICall('site.json', [
                // 'offset' => '60',
                'api_username' => env('DISCOURSE_APIUSER'), // Uses default API user to retrieve all categories
            ], true);
            if (is_object($talk_categories_json) && isset($talk_categories_json->categories)) {
                foreach ($talk_categories_json->categories as $category) {
                    $talk_categories[$category->id] = $category;
                }
                Cache::put('talk_categories_'.Auth::user()->username, $talk_categories, 60 * 24);
            }
        }

        /**
         * Query Discourse API for current logged in user
         * This retrieves all hot topics from Discourse
         */
        if (Cache::has('talk_hot_topics_'.Auth::user()->username)) {
            $talk_hot_topics = Cache::get('talk_hot_topics_'.Auth::user()->username);
        } else {
            $talk_hot_topics = [];
            $talk_hot_topics_json = FixometerHelper::discourseAPICall('top/weekly.json', [
                // 'offset' => '60',
                'api_username' => Auth::user()->username,
            ], true);
            if (is_object($talk_hot_topics_json) && isset($talk_hot_topics_json->topic_list->topics)) {

                $users = collect($talk_hot_topics_json->users);
                $talk_hot_topics = $talk_hot_topics_json->topic_list->topics;
                foreach ($talk_hot_topics as $talk_topic) {
                  $talk_topic->friendly_date = $this->formatCarbonDate($talk_topic->last_posted_at);
                  foreach ($talk_topic->posters as $poster) {
                    if ($user = $users->where('id', $poster->user_id)->first()) {
                      $poster->avatar_url = env('DISCOURSE_URL').Str::replaceFirst('{size}', '45', $user->avatar_template);
                    }
                  }
                }
                Cache::put('talk_hot_topics_'.Auth::user()->username, $talk_hot_topics, 60);
            }
        }

        return [
            'talk_categories' => $talk_categories,
            'talk_hot_topics' => $talk_hot_topics,
        ];
    }

    public function getHostDash()
    {
        return view('dashboard.host');
    }

    private function formatCarbonDate($date)
    {
        $now = Carbon::now();
        $date = Carbon::parse($date);

        if ($now->diffInHours($date) <= 1) {
            return $date->format('i').'m';
        }

        if ($now->diffInHours($date) <= 24) {
            return $date->format('H').'h';
        }

        return $date->diffInDays($now).'d';
    }
}
