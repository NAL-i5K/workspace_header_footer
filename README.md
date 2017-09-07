# i5kworkspace_header_footer

STEPS TO FOLLOW 
===============
	1. Find & open 'header.php' in a text editor.
	2. Change the config settings for the file which includes:

		* Host name ($host)
	  	* Database port number ($port)
	  	* Database name ($db)
	  	* Databse username ($dbuser)
	  	* Databse password ($dbpassword)

	3. Run php script manually '(hostname/{folder_path}/header.php)' to generate or update 'header.html'.
	4. Goto the 'header.php' file location & edit the generated 'header.html' which is ready for reuse.

STEPS TO INCORPORATE INTO genomics-workspace
===============
	1. Copy header.html and footer.html to /genomics-workspace-dir/app/templates/app
	2. Copy css/* to /genomics-workspace-dir/app/static/app/content
	3. Copy js/* to /genomics-workspace-dir/app/static/app/scripts
	4. Configure css/* into "Pipeline - STYLESHEETS - app-layout" in setting.py
	5. Configure js/* into "Pipeline - JAVASCRIPT - app-layout" in setting.py
	6. Run django collectstatic (python manage.py collectstatic)
	
	Note: css name may conflict with css name used in genomics-workspace cause slightly different in appearance. 
	It's better to put prefix here to distinguish them.
