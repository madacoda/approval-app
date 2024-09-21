<?php

function status_badge($status) {
	if($status == 'progress') {
		return '<span class="badge badge-primary">'. $status .'</span>';
	}
	if($status == 'approved') {
		return '<span class="badge badge-success">'. $status .'</span>';
	}
	if($status == 'rejected') {
		return '<span class="badge badge-secondary">' . $status . '</span>';
	}
	if($status == 'done') {
		return '<span class="badge badge-primary-2">' . $status . '</span>';
	}
	return $status;
}