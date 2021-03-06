<?php
	namespace Controllers;

	use Models\Profile;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Profiles{
		// CREATE
	    public static function create($user_id, $country_id, $name, $phone){
	    	$created = Profile::create(['user_id' => $user_id, 'country_id' => $country_id, 'name' => $name, 'phone' => $phone]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Profile::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Profile::find($id);

	    	return $found;
	    }

	    public static function find_byname($name){
	    	$found = Profile::where('name', $name)->first();

	    	return $found;
	    }

	    public static function find_byphone($phone, $country_id){
	    	$found = Profile::where('phone', $phone)->where('country_id', $country_id)->first();

	    	return $found;
	    }

	    public static function find_byuser($user_id){
	    	$found = Profile::where('user_id', $user_id)->first();

	    	return $found;
	    }

	    // UPDATE
	    public static function update($id, $user_id, $country_id, $name, $phone){
	        $_update = Profile::find($id);

	        $_update->user_id = $user_id;
	        $_update->country_id = $country_id;
	        $_update->name = $name;
	        $_update->phone = $phone;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Profile::find($id);

	        return $_destroy->delete();
	    }
	}
?>