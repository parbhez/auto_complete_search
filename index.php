<!-- Website Link -->
https://www.tutsmake.com/laravel-5-7-jquery-ui-autocomplete-search-example/

<!-- In this step we need to create blade view file. Go to app/resources/views and create one file name search.blade.php .

After create blade file put the below html code here with jquery ui and css library file : -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Auto Complete Search Using Jquery UI - Tutsmake.com</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <style>
    .container{
    padding: 10%;
    text-align: center;
   } 
 </style>
</head>
<body>
 
<div class="container">
    <div class="row">
        <div class="col-12"><h2>Laravel 5.7 Auto Complete Search Using Jquery UI</h2></div>
        <div class="col-12">
            <div id="custom-search-input">
                <div class="input-group">
                    <input id="search" name="search" type="text" class="form-control" placeholder="Search" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function() {
    $( "#search" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: "{{url('autocomplete')}}",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    //console.log(obj.city_name);
                    //console.log(obj);
                    return obj.name;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
});
 
</script>   
</body>
</html>

<!--  Make Routes
Now we will create two routes one for show search input box and second for autocomplete search using jquery ui autocomplete. -->

 Route::get('search', 'AutoCompleteController@index');
 Route::get('autocomplete', 'AutoCompleteController@search');

<!-- After successfully create controller go to app/controllers/AutoCompleteController.php and put the below code :  -->
<!-- @@@@@@@@@@@@ Controller Code  @@@@@@@@@@@@@@-->

<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\User;
 
class AutoCompleteController extends Controller
{
 
    public function index()
    {
        return view('search');
    }
 
    public function search(Request $request)
    {
          $search = $request->get('term');
      
          $result = User::where('name', 'LIKE', '%'. $search. '%')->get();
 
          return response()->json($result);
            
    } 
}

