<?php declare(strict_types=1)
class Field {
	
	public function __construct() {
		$this->nationality = explode(',', $this->nationality);
	}
	
	static function getInstance() {
		static $instant;
		if(!is_object($instant)) {
			$instant = new Field;
		}
		return $instant;
	}
	
	static function get($field) {
		$_this = Field::getInstance();
		if(isset($_this->{$field})) {
			return $_this->{$field};
		}
		return false;
	}
	
	private

		$account = array('administrator','Sales','guest'),
		$title = array('Mrs','Mr','Miss'),
		$id_type = array('Identity Document','Passport'),
		$gender = array('Male','Female'),
		$agreement = array('Yes', 'No'),
		$first_language = array( "Afrikaans",   "Amharic",   "Arabic",   "English",   "French",   "Hebrew",   "Ndebele",   "Northern Sotho",   "Russian",   "Sotho",   "Swati",   "Tsonga",   "Tswana",   "Venda","Xhosa","Zulu"),
		$race = array('Black','Asian','Coloured','White'),
		$nationality = 'Afghan,Albanian,Algerian,American,Andorran,Angolan,Antiguans,Argentinean,Armenian,Australian,Austrian,Azerbaijani,Bahamian,Bahraini,Bangladeshi,Barbadian,Barbudans,Batswana,Belarusian,Belgian,Belizean,Beninese,Bhutanese,Bolivian,Bosnian,Brazilian,British,Bruneian,Bulgarian,Burkinabe,Burmese,Burundian,Cambodian,Cameroonian,Canadian,Cape Verdean,Central African,Chadian,Chilean,Chinese,Colombian,Comoran,Congolese,Costa Rican,Croatian,Cuban,Cypriot,Czech,Danish,Djibouti,Dominican,Dutch,East Timorese,Ecuadorean,Egyptian,Emirian,Equatorial Guinean,Eritrean,Estonian,Ethiopian,Fijian,Filipino,Finnish,French,Gabonese,Gambian,Georgian,German,Ghanaian,Greek,Grenadian,Guatemalan,Guinea-Bissauan,Guinean,Guyanese,Haitian,Herzegovinian,Honduran,Hungarian,Icelander,Indian,Indonesian,Iranian,Iraqi,Irish,Israeli,Italian,Ivorian,Jamaican,Japanese,Jordanian,Kazakhstani,Kenyan,Kittian and Nevisian,Kuwaiti,Kyrgyz,Laotian,Latvian,Lebanese,Liberian,Libyan,Liechtensteiner,Lithuanian,Luxembourger,Macedonian,Malagasy,Malawian,Malaysian,Maldivan,Malian,Maltese,Marshallese,Mauritanian,Mauritian,Mexican,Micronesian,Moldovan,Monacan,Mongolian,Moroccan,Mosotho,Motswana,Mozambican,Namibian,Nauruan,Nepalese,Netherlander,New Zealander,Ni-Vanuatu,Nicaraguan,Nigerian,Nigerien,North Korean,Northern Irish,Norwegian,Omani,Pakistani,Palauan,Panamanian,Papua New Guinean,Paraguayan,Peruvian,Polish,Portuguese,Qatari,Romanian,Russian,Rwandan,Saint Lucian,Salvadoran,Samoan,San Marinese,Sao Tomean,Saudi,Scottish,Senegalese,Serbian,Seychellois,Sierra Leonean,Singaporean,Slovakian,Slovenian,Solomon Islander,Somali,South African,South Korean,Spanish,Sri Lankan,Sudanese,Surinamer,Swazi,Swedish,Swiss,Syrian,Taiwanese,Tajik,Tanzanian,Thai,Togolese,Tongan,Trinidadian or Tobagonian,Tunisian,Turkish,Tuvaluan,Ugandan,Ukrainian,Uruguayan,Uzbekistani,Venezuelan,Vietnamese,Welsh,Yemenite,Zambian,Zimbabwean',
		$marital_status = array('Single','Married','Divorced','Other'),
		$have_children  = array('0','1','2','3','4','5','6','7','8'),
		$passport = array('Yes', 'No'),
		$home_relationship = array('Parent','Sibling','Grandparent','Niece/Nephew','Aunt/Uncle','Other'),
		$address_to_use = array('University', 'Home'),
        
        $account_status = array('Active','Inactive','Suspended'),
        $note_sub_comments = array('Request', 'Follow up'),
        
		$rsvp = array('Pending','Yes','No'),
		$food_option = array('Standard','Halaal','Kosher','Vegetarian'),
		$contact_type = array("NGO",'Employers','Trainers/speakers','Corporates','Friends','Universities'),
		//$hired_after = array('Before completing my studies','<3 months','<6 months','<9 months', 'More than 9 months'),
						

		$ethnic_group = array('Jewish','Muslim','Christian','Druze','Circassians','Bedouin','Armenian'),
		$language = array(),
		

	$job_type = array('Kitchen','BIC','Vanity','Reception'),
	$cupboard_height = array('Highline','Standard','Custom','N/A'),
	$finishes = array('Melamine','Wrap','Duco','Veneer','Semi Solid'),
	$colour = array('AFRICAN WENGE','AMERICAN WALLNUT','BLACK CHERRY','ESPERANZA OAK','COIMBRA','ENYA WALLNUT','HARVARD CHERRY','CADBURY OAK','ICEBERG WHITE','LANZA OAK','SHALE OAK','STORM GREY','SUMMER OAK','SUPER BLACK','WISCONSEN WALLNUT','MONUMENT OAK','VERZASCA OAK','CAPPUCCINO','ESPRESSO','CREAM','BAVARIAN BEECH','BODENSEE CHERRY','FOLSKSTONE GREY','VANCOUVER MAPLE','NATURAL OAK','BURGANDY MAHOGANY','AGED STONE','BALSA','BEECH','BURNT OAK','CANADIAN MAPLE','CHERRY ROYAL','FRENCH WALLNUT','MEMPHIS CHERRY','MOZAMBIQUE WENGE','NATURAL OAK','ROYAL MAHOGANY','SAHARA','LARACINA','LUNAR ASH','SMOKED CEDAR','WASHED SHALE','AFRICAN WENGE','AMERICAN WALNUT','BALSA','BANSTEAD CUT','BLACK CHERRY','BAVARIAN BEECH','BODENSEE CHERRY','BURGAN MAHOGANY','CHERRY ROYAL','COIMBRA','DRIFTWOOD OAK','ENYA WALNUT','HARVARD CHERRY','LARACINA','MEMPHIS CHERRY','MONUMENT OAK','NATURAL OAK','POLAR/ICEBERG WHITE','ROYAL MAHOGANY','SKIPWOOD','SMOKED CEDAR','SONOMA OAK','SUMMER OAK','VANCOUVER MAPLE','VERZASCA OAK','WOODLINE CREAM','Summer White','Woodgrains','Plain Colours','iceberg white ','BLACK','CREAM','GREY','STORM GREY','WHITE','AMERICAN WALNUT VENEER','AMERICAN WALNUT M.MATCH BACKER','AMERICAN WALNUT S/F (OKOUME BACKER)','BUBINGA D/F','BUBINGA M.MATCH BACKER','BUBINGA S/F (OKOUME BACKER)','CHERRY D/F','CHERRY M.MATCH BACKER','CHERRY S/F (OKOUME BACKER)','CROWN MAHOGANY D/F','CROWN MAHOGANY M.MATCH BACKER','CROWN MAHOGANY S/F (OKOUME BACKER)','CROWN MAHOGANY S/F (SAPELE BACKER)','EHIE D/F','EHIE S/F (OKOUME BACKER)','ETIMOE D/F','ETIMOE S/F (OKOUME BACKER)','KIAAT D/F ALL BROWN','KIAAT M.MATCH BACKER','KIAAT S/F ALL BROWN (OKOUME BACKER)','MAPLE D/F','MAPLE M.MATCH BACKER','MAPLE S/F (OKOUME BACKER)','OKOUME D/F','OREGON PINE D/F','PINE D/F','PINK BEECH D/F','PINK BEECH M.MATCH BACKER','PINK BEECH S/F (OKOUME BACKER)','RED OAK D/F','RED OAK M.MATCH BACKER','RED OAK S/F (OKOUME BACKER)','SAPELE D/F','SAPELE S/F (OKOUME BACKER)','WENGE D/F','WENGE S/F (OKOUME BACKER)','WHITE ASH D/F','WHITE ASH M.MATCH BACKER','WHITE ASH S/F (OKOUME BACKER)','WHITE BEECH D/F','WHITE BEECH M.MATCH BACKER','WHITE BEECH S/F (OKOUME BACKER)','WHITE OAK D/F','WHITE OAK M.MATCH BACKER','WHITE OAK S/F (OKOUME BACKER)','ZEBRANO D/F','ZEBRANO S/F (OKOUME BACKER)'),
	$edging = array('2mm','1mm','0.4mm'),
	$kickplates = array('Tiled','Same as doors','Aluminium','Same as tops', 'On Legs'),	
	$top_thickness= array('32mm','30mm','20mm'),
	
	$top_type = array('Quartz (sparkle, beech, sorbet)','Formica (Meteor, Isis Kakino)','Granite (Rustenburg, Zimbabwe)', 'Veneer (Kiaat, Cherry)'),	
	$quartz= array('sparkle', 'beech', 'sorbet'),
	$formica= array('Meteor', 'Isis Kakino'),
	$granite = array('Rustenburg', 'Zimbabwe'),
	$veneer = array('Kiaat', 'Cherry'),

	$handle_size = array('96mm', '128mm', '196mm'),
	$handle_type = array('Roman Bar', 'Neptune', 'Black nickel'),
	$runners = array('Telescopic', 'Soft Close', 'Integrated'),
	$hinges = array('Standard', 'Soft Close'),
	$sinks = array('Double bowl standard', 'Single bowl standard'),
	$prep_bowl = array('Standard prep'),
	
	$yesno= array('Yes','No'),
	$payment_type = array('EFT', 'CASH', 'NO PAYMENT');


	}
?>