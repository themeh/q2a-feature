<?php
class qa_feature_admin {

	function option_default($option) {

		switch($option) {
			default:
				return null;				
		}

	}

	function allow_template($template)
	{
		return ($template!='admin');
	}       

	function admin_form(&$qa_content)
	{                       

		// Process form input

		$ok = null;

		if (qa_clicked('qa_featured_questions_save')) {
			qa_opt('qa_featured_questions_level',qa_post_text('qa_featured_questions_level'));
			$ok = qa_lang('admin/options_saved');
		}
		$showoptions = array(
				QA_USER_LEVEL_EXPERT => "Experts",
				QA_USER_LEVEL_EDITOR => "Editors",
				QA_USER_LEVEL_MODERATOR =>      "Moderators",
				QA_USER_LEVEL_ADMIN =>  "Admins",
				QA_USER_LEVEL_SUPER =>  "Super Admins",
				);

		// Create the form for display

		$fields = array();
		$fields[] = array(

				'label' => 'User Level for Featuring',
				'tags' => 'name="qa_featured_questions_level"',
				'value' => @$showoptions[qa_opt('qa_featured_questions_level')],
				'type' => 'select',
				'options' => $showoptions,
				);

		return array(           
				'ok' => ($ok && !isset($error)) ? $ok : null,

				'fields' => $fields,

				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'NAME="qa_featured_questions_save"',
					     ),
					),
			    );
	}
}

