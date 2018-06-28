<?php

namespace App\Http\Controllers;

use Auth;
use App\Brands;
use FixometerHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandsController extends Controller
{

  public function index() {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    $all_brands = Brands::all();

    return view('brands.index', [
      'title' => 'Brands',
      'brands' => $all_brands
    ]);
  }

  public function getCreateBrand() {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    return view('brands.create', [
      'title' => 'Add Brand',
    ]);

  }

  public function postCreateBrand(Request $request) {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    $brand = Brands::create([
      'brand_name' => $request->input('brand-name')
    ]);

    return Redirect::to('brands/edit/'.$brand->id);

  }

  public function getEditBrand($id) {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    $brand = Brands::find($id);

    return view('brands.edit', [
      'title' => 'Edit Brand',
      'brand' => $brand,
    ]);

  }

  public function postEditBrand($id, Request $request) {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    Brands::find($id)->update([
      'brand_name' => $request->input('brand-name')
    ]);

    return Redirect::back()->with('message', 'Brand updated!');

  }

  public function getDeleteBrand($id) {

    if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') )
      return redirect('/user/forbidden');

    Brands::find($id)->delete();

    return Redirect::back()->with('message', 'Brand deleted!');

  }

}
