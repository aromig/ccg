<?php

class ToonTown {

	public $gags = array(
		"toonup"=>array("", "Feather", "Megaphone", "Lipstick", "Bamboo Cane", "Pixie Dust", "Juggling Balls", "High Dive"),
		"trap"=>array("", "Banana Peel", "Rake", "Marbles", "Quicksand", "Trapdoor", "TNT", "Railroad"),
		"lure"=>array("", "$1 Bill", "Small Magnet", "$5 Bill", "Big Magnet", "$10 Bill", "Hypno Goggles", "Presentation"),
		"sound"=>array("", "Bike Horn", "Whistle", "Bugle", "Aoogah", "Elephant Trunk", "Foghorn", "Opera Singer"),
		"throw"=>array("", "Cupcake", "Fruit Pie Slice", "Cream Pie Slice", "Whole Fruit Pie", "Whole Cream Pie", "Birthday Cake", "Wedding Cake"),
		"squirt"=>array("", "Squirting Flower", "Glass of Water", "Squirt Gun", "Seltzer Bottle", "Fire Hose", "Storm Cloud", "Geyser"),
		"drop"=>array("", "Flower Pot", "Sandbag", "Anvil", "Big Weight", "Safe", "Grand Piano", "Toontanic")
		);

	public $cogsuits = array(
		"sellbot"=>array("", "Cold Caller", "Telemarketer", "Name Dropper", "Glad Hander", "Mover & Shaker", "Two-Face", "The Mingler", "Mr. Hollywood", "Mr. Hollywood 50"),
		"cashbot"=>array("", "Short Change", "Penny Pincher", "Tightwad", "Bean Counter", "Number Cruncher", "Money Bags", "Loan Shark", "Robber Baron", "Robber Baron 50"),
		"lawbot"=>array("", "Bottom Feeder", "Bloodsucker", "Double Talker", "Ambulance Chaser", "Back Stabber", "Spin Doctor", "Legal Eagle", "Big Wig", "Big Wig 50"),
		"bossbot"=>array("", "Flunky", "Pencil Pusher", "Yesman", "Micromanager", "Downsizer", "Head Hunter", "Corporate Raider", "The Big Cheese", "The Big Cheese 50")
		);

	public $suit_levels = array(
		"Cold Caller"=>array(1, 2, 3, 4, 5),
		"Telemarketer"=>array(2, 3, 4, 5, 6),
		"Name Dropper"=>array(3, 4, 5, 6, 7),
		"Glad Hander"=>array(4, 5, 6, 7, 8),
		"Mover & Shaker"=>array(5, 6, 7, 8, 9),
		"Two-Face"=>array(6, 7, 8, 9, 10),
		"The Mingler"=>array(7, 8, 9, 10, 11),
		"Mr. Hollywood"=>array(8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49),
		"Short Change"=>array(1, 2, 3, 4, 5),
		"Penny Pincher"=>array(2, 3, 4, 5, 6),
		"Tightwad"=>array(3, 4, 5, 6, 7),
		"Bean Counter"=>array(4, 5, 6, 7, 8),
		"Number Cruncher"=>array(5, 6, 7, 8, 9),
		"Money Bags"=>array(6, 7, 8, 9, 10),
		"Loan Shark"=>array(7, 8, 9, 10, 11),
		"Robber Baron"=>array(8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49),
		"Bottom Feeder"=>array(1, 2, 3, 4, 5),
		"Bloodsucker"=>array(2, 3, 4, 5, 6),
		"Double Talker"=>array(3, 4, 5, 6, 7),
		"Ambulance Chaser"=>array(4, 5, 6, 7, 8),
		"Back Stabber"=>array(5, 6, 7, 8, 9),
		"Spin Doctor"=>array(6, 7, 8, 9, 10),
		"Legal Eagle"=>array(7, 8, 9, 10, 11),
		"Big Wig"=>array(8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49),
		"Flunky"=>array(1, 2, 3, 4, 5),
		"Pencil Pusher"=>array(2, 3, 4, 5, 6),
		"Yesman"=>array(3, 4, 5, 6, 7),
		"Micromanager"=>array(4, 5, 6, 7, 8),
		"Downsizer"=>array(5, 6, 7, 8, 9),
		"Head Hunter"=>array(6, 7, 8, 9, 10),
		"Corporate Raider"=>array(7, 8, 9, 10, 11),
		"The Big Cheese"=>array(8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49)
		);

	public $districts = array(
		"primary"=>"Pastel Plains",
		"backup"=>array("Eraser Oasis", "Brush Bay")
		);

	public $prior_run_length = array(
		"VP"=>"+1 hour",
		"CFO"=>"+45 minutes",
		"CJ"=>"+45 minutes",
		"CEO"=>"+45 minutes"
		);

	// Run Schedule in Central Time
	public $run_schedule = array(
		"Monday"=>array(
			"battle"=>array("CEO","VP","CFO","CJ"),
			"start_time"=>array("5:00 AM", "12:00 PM", "6:00 PM"),
			"thread"=>"362383"
			),
		"Tuesday"=>array(
			"battle"=>array("VP", "CFO", "CJ", "CEO"),
			"start_time"=>array("5:00 AM", "9:00 AM", "3:00 PM", "7:00 PM"),
			"thread"=>"362384"
			),
		"Wednesday"=>array(
			"battle"=>array("CEO","VP","CFO","CJ"),
			"start_time"=>array("5:00 AM", "11:00 AM", "3:00 PM", "6:15 PM"),
			"thread"=>"362344"
			),
		"Thursday"=>array(
			"battle"=>array("CJ", "CEO", "VP", "CFO"),
			"start_time"=>array("5:00 AM", "11:00 AM", "4:00 PM", "7:30 PM"),
			"thread"=>"368797"
			),
		"Friday"=>array(
			"battle"=>array("CFO", "CJ", "CEO", "VP"),
			"start_time"=>array("5:00 AM", "11:00 AM", "4:00 PM", "7:30 PM"),
			"thread"=>"368800"
			),
		"Saturday"=>array(
			"battle"=>array("CJ", "CEO", "VP", "CFO"),
			"start_time"=>array("5:00 AM", "9:00 AM", "12:15 PM", "4:00 PM", "7:30 PM"),
			"thread"=>"362345"
			),
		"Sunday"=>array(
			"battle"=>array("VP", "CFO", "CJ", "CEO"),
			"start_time"=>array("5:00 AM", "12:00 PM", "4:00 PM", "7:15 PM"),
			"thread"=>"368923"
			),
		);

	public $beanfest_days = array(
		"Saturdays"=>array("8:15 AM")
		);

	public $vp_sos_card = array(
		"", "Baker Bridget", "Barbara Seville", "Barnacle Bessie", "Clerk Clara", "Clerk Penny", "Clerk Ray", "Clerk Will", "Clumsy Ned", "Daffy Don", "Doctor Drift", "Flim Flam", "Flippy", "Franz Neckvein", "Julius Wheezer", "Lil Oldman", "Madame Chuckle", "Melody Wavers", "Moe Zart", "Mr. Freeze", "Nancy Gas", "Professor Guffaw", "Professor Pete", "Shelly Seaweed", "Sid Sonata", "Sofie Squirt", "Soggy Bottom", "Soggy Nell", "Sticky Lou", "Stinky Ned", "Unknown"
		);

	public $cfo_unite_phrase = array(
		"", "Toon-Up! 10 Laff", "Toon-Up! 20 Laff", "Toon-Up! 40 Laff", "Toon-Up! 80 Laff", "Toon-Up! Max Laff", "Gag-up! Heal", "Gag-up! Trap", "Gag-up! Lure", "Gag-up! Sound", "Gag-up! Throw", "Gag-up! Squirt", "Gag-up! Drop", "Gag-up! All", "100 Jellybeans", "200 Jellybeans", "350 Jellybeans", "600 Jellybeans", "Unknown"
		);

	public $cj_summons = array(
		"", "Summon Cog", "Summon Cog Building", "Summon Invasion", "Unknown"
		);

	public $ceo_pink_slip = array(
		"", "1 Pink Slip", "2 Pink Slips", "3 Pink Slips", "4 Pink Slips", "5 Pink Slips"
		);

	public $battle_status = array(
		"vp"=>array("Danced", "Sad in Cog Round", "Sad in Skele Round", "Sad in Pie Round", "Disconnected", "Alt-F4'd", "Unknown"),
		"cfo"=>array("Danced", "Sad in Cog Round", "Sad in Crane Round", "Disconnected", "Alt-F4'd", "Unknown"),
		"cj"=>array("Danced", "Sad in Cog Round", "Sad in Evidence Round", "Disconnected", "Alt-F4'd", "Unknown"),
		"ceo"=>array("Danced", "Sad in Waiter Round", "Sad in Cog Round", "Sad in CEO Round", "Disconnected", "Alt-F4'd", "Unknown")
		);
}

?>