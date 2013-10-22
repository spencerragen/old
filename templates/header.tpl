<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Language" content="en-us">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<title>{$page_title}</title>
	{foreach from=$css item=link}
		<link rel="stylesheet" href="{$tpl_dir}css/{$link}" type="text/css" />
	{/foreach}
	{foreach from=$js item=link}
		<script src="{$tpl_dir}js/{$link}" type="text/javascript"></script>
	{/foreach}
	</head>
	
	<body>
		<div id="ctr1"></div>
		<div id="primary_container">
			{if isset($error_message)}
			<div id="error_message">{$error_message}</div>
			{/if}
