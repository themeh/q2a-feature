<?php
class qa_feature_admin {

	function option_default($option) {

		switch($option) {
			case 'qa_featured_questions_level': 
				return QA_USER_LEVEL_MODERATOR;
			default:
				return null;				
		}

	}
	 function init_queries($tableslc) {
                require_once QA_INCLUDE_DIR."db/selects.php";
		$queries = array();
		if(qa_opt('qa_featured_enable_user_reads'))
		{
		 $tablename=qa_db_add_table_prefix('userreads');
		 $usertablename=qa_db_add_table_prefix('users');
                if(!in_array($tablename, $tableslc)) {
                        $queries[] = "create table if not exists $tablename
				 (
  `userid` int(10) unsigned NOT NULL,
  `postid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`postid`),
  KEY `entitytype` (`postid`),
   FOREIGN KEY (`userid`) REFERENCES `$usertablename` (`userid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		}
		}
		return $queries;
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
			qa_opt('qa_featured_enable_user_reads',(bool)qa_post_text('qa_featured_enable_user_reads'));
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
				'label' => 'Min. User Level Required for Featuring',
				'tags' => 'name="qa_featured_questions_level"',
				'value' => @$showoptions[qa_opt('qa_featured_questions_level')],
				'type' => 'select',
				'options' => $showoptions,
				);
		$fields[] = array(
				'label' => 'Enable Read Lists for Users',
				'tags' => 'name="qa_featured_enable_user_reads"',
				'value' => qa_opt('qa_featured_enable_user_reads'),
				'type' => 'checkbox',
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

