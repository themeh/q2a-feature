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
				qa_redirect( qa_request(), $_GET );
			}
			if(isset($_POST['unfeature-button'])  )
			{
				$postid = $_POST['unfeature-button'];	
				qa_db_postmeta_clear($postid, "featured");
				qa_redirect( qa_request(), $_GET );
			}
		}
	}

	qa_check_page_clicks_base();
}


?>
