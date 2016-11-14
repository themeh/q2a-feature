<?php
function qa_db_posts_basic_selectspec($voteuserid=null, $full=false, $user=true)
{
	$request = qa_request_parts();
	$request = $request[0];
	if(($request ===  'questions' || $request ===  'unanswered') && (qa_get('sort') == 'featured') )
	{
		$res = qa_db_posts_basic_selectspec_base($voteuserid, $full, $user);
		$res['source'] .= " join ^postmetas gf on ^posts.postid = gf.postid and gf.title like 'featured'";
		return $res;
	}
	return  qa_db_posts_basic_selectspec_base($voteuserid, $full, $user);
}
function qa_q_list_page_content($questions, $pagesize, $start, $count, $sometitle, $nonetitle,
		$navcategories, $categoryid, $categoryqcount, $categorypathprefix, $feedpathprefix, $suggest,
		$pagelinkparams=null, $categoryparams=null, $dummy=null)
{
	$request = qa_request_parts();
	$request = $request[0];
	if(($request ===  'questions' || $request ===  'unanswered') && (qa_get('sort') == 'featured') )
	{
		$pagelinkparams= array("sort" => "featured");
		$categorytitlehtml = qa_html($navcategories[$categoryid]['title']);		 
		$sometitle = $categoryid != null ? qa_lang_html_sub('featured_lang/featured_qs_in_x', $categorytitlehtml) : qa_lang_html('featured_lang/featured_qs_title');
		$nonetitle = $categoryid != null ? qa_lang_html_sub('featured_lang/nofeatured_qs_in_x', $categorytitlehtml) : qa_lang_html('featured_lang/nofeatured_qs_title');
		$feedpathprefix =  null;
		if(!$categoryid){
			$count=qa_opt('feeatured_qcount');
		}
		else{
			$tcount=count($questions);
			if($tcount < $pagesize)
				$count = $start+$tcount;
		}
	}

	return qa_q_list_page_content_base($questions, $pagesize, $start, $count, $sometitle, $nonetitle,
			$navcategories, $categoryid, $categoryqcount, $categorypathprefix, $feedpathprefix, $suggest,
			$pagelinkparams, $categoryparams, $dummy);
}

function updatefeaturedcount()
{
	$query = qa_db_query_sub("select count(*) from ^postmetas where title like 'featured'");
	$count = qa_db_read_one_value($query);
	qa_opt('featured_qcount', $count);
}

function qa_check_page_clicks()
{
	global $qa_page_error_html;
	global  $qa_request;

	if ( qa_is_http_post() ) {
		if(qa_get_logged_in_level()>=  qa_opt('qa_featured_questions_level'))
		{
			if(isset($_POST['feature-button'])  )
			{
				$postid = $_POST['feature-button'];	
				qa_db_postmeta_set($postid, "featured", "1");
				updatefeaturedcount();
				qa_redirect( qa_request(), $_GET );
			}
			if(isset($_POST['unfeature-button'])  )
			{
				$postid = $_POST['unfeature-button'];	
				qa_db_postmeta_clear($postid, "featured");
				updatefeaturedcount();
				qa_redirect( qa_request(), $_GET );
			}
		}
	}

	qa_check_page_clicks_base();
}


?>
