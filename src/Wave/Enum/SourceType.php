<?php
namespace Wave\Enum;



class SourceType
{
	use \Objection\TEnum;
	
	
	const GIT	= 'git';
	const SVN	= 'svn';
}