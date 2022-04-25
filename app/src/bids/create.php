<?php
	// start up eloquent
	require_once '_bids.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/email/_email.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/model.php';

	use Controllers\Bids;
	use Controllers\Packages;
	use Controllers\Profiles;
	use Controllers\Users;

	Class Create_Bids extends _Bids {
		private $user_id;
		private $bid;

		function __construct($bid) {
			$this->bid = $bid;

			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function bid(){
			$package_id = $this->bid->get_package_id(); // get package id
			$user_id = $this->user_id;
			$offer = $this->bid->get_offer(); // get offer

			$deadline = $this->bid->get_deadline(); // get deadline
			$deadline = $this->create_date($deadline); // configure and return deadline

			$is_success = false;
			
			$bid = Bids::find_byuser($package_id, $user_id); // to check, if user has already placed a bid for this package

			// // if bid already exists, update bid, else create bid
			if(isset($bid->bidder_id)){
				$saved = Bids::update($bid->id, $package_id, $user_id, $offer, $deadline);
				$is_success = $saved;
			}
			else{
				$status = $this->get_status('active');
				
				$bid = Bids::create($package_id, $user_id, $offer, $status->id, $deadline);
				$is_success = isset($bid->id);
			}

			// bid was created
			if($is_success){
				$package = Packages::find($package_id);
				
				$deadline = $offer.' hour(s) from now '.date('Y-m-d h:i:s');
				
				$this->sendemail($package, $offer, $deadline);

				echo 'success';
			}
			else{
				echo 'failed';
			}

			return;
		}

		// add a couple of hours to the present date and time and return the value
		private function create_date($deadline){
	    	$deadline = date('Y-m-d h:i:s', strtotime('+ '.$deadline.' hours'));

	    	return $deadline;
		}

        // SEND EMAIL to emailaddress FOR USER CONFIRMATION
        function emailbody($package, $bidder, $offer, $deadline){
         	// state and country
         	$state = $package->state;
         	$country = $state->country->name;
         	$state = $state->name;
            
            $package_tag = $country.'-'.$state.'-'.$package->id;
            
            $url = "https://travelpackagebids.com/package.php?package=".$package_tag;
            
            // OWNER
            $owner = $this->owners_profile($package->user);
            
            // BIDDER
            $bidder_phone = $bidder->phone_code.$bidder->phone;
            $offer = number_format($offer);
            
            return '<h4>Hello '.$owner->name.',</h4>
            
                <p>
                    <span><b style="text-transform: capitalize">'.$bidder->name.'</b> just placed a Bid on your travel package <a href="'.$url.'" style="color: #03C6C1;text-transform: capitalize">'.$country.', '.$state.'</a> on</span> 
                    <a href="https://travelpackagebids.com">TravelPackageBids</a>.
                </p>

                <p style="margin-bottom: 15px;">
                 	You can <a href="tel:'.$bidder_phone.'" style="color: white;border: #03C6C1;background-color: #03C6C1;padding:5px 8px 5px 8px;text-decoration: none;border-radius: 6px;">Call '.$bidder->name.'</a>, to talk further about their offer of $'.$offer.', which expires in '.$deadline.'
                </p>
                
                <small style="font-size: 10px">NOTE: If you\'re not a Registered Travel Agent on <a href="https://travelpackagebids.com">TravelPackageBids</a>, Kindly Ignore this message. Thank you.</small>';
        }
        
		function sendemail($package, $offer, $deadline){
		    $bidder = $this->bidders_profile();
		    
		    if(!empty($bidder->phone)){
    			// GET USER
    			$email = $package->user->email;
    
                $subject = "[TravelPackageBids] You just received an Offer";
                $body = $this->emailbody($package, $bidder, $offer, $deadline);
                
                // send email
                $email = new Email($email, $subject, $body);
                
                $email->send();
		    }
		}

		function owners_profile($user){
			return $this->get_user($user->id);
		}
		
		function bidders_profile(){
		    $user_id = $this->user_id;
		    
			return $this->get_user($user_id);
		}
		
		function get_user($user_id){
			$_profile = new Profile('', '', '', '');

			if(isset($user_id)){
				$profile = Profiles::find_byuser($user_id);

				if(isset($profile->id)){
					$country = $profile->country->name;
					$phone_code = $profile->country->phone_code;

					$_profile = new Profile($country, $profile->name, $profile->phone, $profile->id, $phone_code);
				}
				else{
					$user = Users::find($user_id);

					if(isset($user->id)){
                    	$name = isset($user->email) ? explode('@', $user->email)[0] : "";
						$_profile = new Profile('', $name, '', '', '');
					}
				}
			}

			return $_profile;
		}
	}
?>