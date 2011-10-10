<?php 
define("COMMON_FIRST_NAMES", "lists/common-first.txt");
define("COMMON_LAST_NAMES", "lists/common-last.txt");
define("BUSINESS_NAMES","lists/business-names.txt");
define("STREET_ADDRESSES","lists/street-addresses.txt");
define("CITY_DETAILS","lists/city-details.txt");
define("PHONE_NUMBERS","lists/phone-numbers.txt");

class Contact {
	private $company;
	private $full_name;
	private $first_name;
	private $last_name;
	private $street;
	private $city;
	private $phone;
	
	public function Contact() {
		$this->generate_company();
		$this->generate_name();
		$this->generate_address();
		$this->generate_phone();	
	}
	
	public function generate_company() {
		$this->company = trim($this->random_line(BUSINESS_NAMES));
	}
	
	public function generate_name() {
		$this->full_name = ucfirst(strtolower(trim($this->random_line(COMMON_FIRST_NAMES)))) . " " . ucfirst(strtolower(trim($this->random_line(COMMON_LAST_NAMES))));
		$this->first_name = ucfirst(strtolower(trim($this->random_line(COMMON_FIRST_NAMES))));
		$this->last_name = ucfirst(strtolower(trim($this->random_line(COMMON_LAST_NAMES))));
	}
	
	public function generate_address() {
		$this->street = trim($this->random_line(STREET_ADDRESSES));
		$this->city = trim($this->random_line(CITY_DETAILS));
	}
	
	public function generate_phone() {
		$this->phone = trim($this->random_line(PHONE_NUMBERS));
	}
	
	public function get_company() {
		return $this->company;
	}
	
	public function get_full_name() {
		return $this->full_name;
	}
	
	public function get_address() {
		return $this->street . "\n" . $this->city;
	}
	
	public function get_phone() {
		return $this->phone;
	}
	
	public function get_full_contact() {
		return $this->company . "\n" . $this->full_name . "\n" . $this->get_address() . "\n" . $this->phone;
	}
	
	public function get_partial_contact() {
		return $this->full_name . "\n" . $this->get_address() . "\n" . $this->phone;
	}
	
	public function random_line($filename) { 
		$lines = file($filename); 
		return $lines[array_rand($lines)]; 
	} 
	
}

?>