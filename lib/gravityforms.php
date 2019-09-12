<?php

// returns a gravity form ID by looking up the gform title; e.g. getGformIDByTitle('My Awesome Form');
function getGformIDByTitle($title) {
	$forms = GFAPI::get_forms();
	$key = array_search($title, array_column($forms, 'title'));
	return $forms[$key]['id'];
}
