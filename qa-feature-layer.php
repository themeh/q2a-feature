<?php

class qa_html_theme_layer extends qa_html_theme_base {


	function doctype(){
		global $qa_request;
		$request = qa_request_parts();
		$request = $request[0];
		qa_html_theme_base::doctype();
		if((strcmp($request,'questions') == 0) || (strcmp($request,'unanswered') == 0)) {
			$request='questions';
			$qa_request = 'featured';
			if (isset($categoryslugs))
				foreach ($categoryslugs as $slug)
					$request.='/'.$slug;
			$this->content['navigation']['sub']['featured']= array(
					'label' => qa_lang_html('featured_lang/featured'),
					'url' => qa_path_html($request, array('sort' => 'featured')),
					'selected' => (qa_get('sort') === 'featured')

					);
		}

	}

	public function q_view_buttons($q_view)
	{
		if (!empty($q_view['form'])) {
			$user_level = qa_get_logged_in_level();
			if($user_level >=  qa_opt('qa_featured_questions_level') )
			{

				$postid=$q_view['raw']['postid'];
				if(qa_db_postmeta_get($postid, "featured") == null)
				{
					$q_view['form']['buttons'][] = array("tags" => "name='feature-button' value='$postid' title='".qa_lang_html('featured_lang/feature_pop')."'", "label" => qa_lang_html('featured_lang/feature')); 
				}
				else{
					$q_view['form']['buttons'][] = array("tags" => "name='unfeature-button' value='$postid' title='".qa_lang_html('featured_lang/unfeature_pop')."'", "label" => qa_lang_html('featured_lang/unfeature')); 
				}
			}

		}
		qa_html_theme_base::q_view_buttons($q_view);
	}



}

