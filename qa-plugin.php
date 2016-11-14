<?php
        
                        
    if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
                    header('Location: ../../');
                    exit;   
    }               

    qa_register_plugin_module('module', 'qa-feature-admin.php', 'qa_feature_admin', 'Feature Questions');
    qa_register_plugin_layer('qa-feature-layer.php', 'Feature Layer');
    qa_register_plugin_overrides('qa-feature-overrides.php', 'Feature Override');
	qa_register_plugin_phrases('qa-feature-lang-*.php', 'featured_lang');    
/*                              
    Omit PHP closing tag to help avoid accidental output
*/                              
                          

