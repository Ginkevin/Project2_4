<?php
	class person {
		var $name;
		
			function set_name($new_name){
				$this->name = $new_name;
			}
			
			function get_name(){
				return $this->name;
			}
	}
	
	class persoon {
		var $naam;
		protected $pincode = 205;
		
		function __construct($persoon_naam){
			$this->naam = $persoon_naam;
		}
		
		function get_name(){
			return $this->naam;
		}
		
		function get_pincode(){
			return $this->pincode;
		}
	}
?>