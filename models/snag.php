<?php
class Snag extends AppModel {
	
	const table = 'snags';

	public $user_id = null;
	
	// private $type_text = array(
	// 	'personal' 		=> '<a href="/profile/add/0/0">Complete section: Personal Information</a>',
	// 	'contact' 		=> '<a href="/profile/add/0/1#contact">Complete section: Contact Information</a>',
	// 	'banking' 		=> '<a href="/profile/add/0/2#banking">Complete section: Banking Information</a>',
	// 	'misc' 			=> '<a href="/profile/add/0/3#intrests">Complete section: About yourself</a>',
	// 	'scolar' 	    => '<a href="/scholarship/add">Complete section: Scholarships Information</a>',
	// 	'a_academic' 	=> '<a href="/academic/add/">Complete section: Academics</a>',
	// 	'u_academic'	=> '<a href="/academic/add/">Please provide us with your latest academic results</a>',
 //        'u_work'        => '<a href="/internship/add/">Please provide us with your latest Part-time/Vac work information</a>',
 //        'a_work' 	    => '<a href="/internship/add/">Complete section: Part-time/Vac work</a>',
 //        'a_upload'      => '<a href="/document/add/">Please upload your full academic transcript</a>',
 //        'u_upload'      => '<a href="/document/add/">Please provide us with your latest academic transcript</a>',
 //        'a_alumni'		=> '<a href="/alumni/add">Please provide us with your most up-to-date post graduate information</a>',
 //        'a_letter'		=> '<a href="/letter/add">Please provide us with your anual letter to Martin</a>',
 //        'a_result'		=> '<a href="/result/add">Have you passed your most recent semester/year/exams?</a>'
	// );

	public $validate = array(
        'not_null' 	=> array('snag')
    );




}
?>