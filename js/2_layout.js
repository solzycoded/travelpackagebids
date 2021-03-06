$(function () {
	// bids/offers
	const _bids = new Bids();
 
	_bids.show_createoffer();
	_bids.create_offer();
	_bids.on_modalshown();
	_bids.on_modalhidden();
	_bids.activate();
	_bids.prevent_bidding();

	// user
	const _user = new User();

	_user.logout();

	// COMMENTS
	const _comments = new Comments();

	// load comments
	const is_commentactive = $('.loading-comments').html();
	
    // alert(is_commentactive);
    
    // only when user is on the comments page
	if(is_commentactive!==undefined){
		let package_id = $.trim($('#package_id').val());
		_comments.load_comments(package_id); // load comments
		
		_comments.prevent_comment();
	}
});

// COMMENTS
const load_comments = function(_comments){
	// _comments.load_comments();
}

const send_comment = function(_this){ // post user's comment, to comments
	const _comments = new Comments();

	_comments.send_comment(_this);
}

const comment_result = function(result, success, failure){
    let status = {icon: '', message: '', backcolor: ''};

    if(result=='success'){
        status.icon = 'check';
        status.message = success;
        status.backcolor = 'green';
    }
    else{
        status.icon = 'exclamation';
        status.message = failure;
        status.backcolor = 'red';
    }

    let content = '<i class="fa-solid fa-circle-'+status.icon+'"></i> <span>'+status.message+'</span>';

    $('.comment-response:eq(0)')
    .html(content)
    .css({'opacity': 1, 'background-color': status.backcolor, 'color': 'white'});
}

const prevent_reply = function(_this){
	if(_this!==undefined){
		const _comments = new Comments();

		_comments.prevent_reply(_this);
	}
}

const bid_status = function(_this){
	const _bids = new Bids();

	_bids.activate(_this);
}

const show_offer = function(_this){
	const _bids = new Bids();

	_bids.edit_offer(_this); // append offer and deadline value to the modal
	_bids.show_offer(_this); // show offer modal
}