<?php
	namespace Controllers;

	use Models\Reply;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Replies{
		// CREATE
	    public static function create($comment_id, $reply_id){
	    	$created = Reply::firstOrCreate(['comment_id' => $comment_id, 'reply_id' => $reply_id]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Reply::all();

	        return $get;
	    }

	    public static function find_byreply($comment_id){
	        $get = Reply::where('reply_id', $comment_id)->first();

	        return $get;
	    }

	    public static function find_bycomment($comment_id){
	        $get = Reply::where('comment_id', $comment_id)->get();

	        return $get;
	    }

	    // UPDATE
	    public static function update($id, $comment_id, $reply_id){
	        $_update = Reply::find($id);

	        $_update->comment_id = $comment_id;
	        $_update->reply_id = $reply_id;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Reply::find($id);

	        return $_destroy->delete();
	    }
	}
?>