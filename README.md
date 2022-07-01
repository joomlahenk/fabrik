Fabrik for J!4.x
================

This is a test version, not a complete working version of fabrik.
Work is in progress to get it al working.

Final version:
================

Working in J!4.x only, does not work on <J!4.
Package removed (did not work and was not supported anyway).
All version hacks (release) removed, to be reimplemented for >J!4 and <J!5; we start with the latest J!4 version.
All unused functions removed (yes, there are some).
Cleaner install: only install what we need. Do a real install of library files, not install and copy (this is called 'moving files').
Visualization removed, because most does not work well and there are much better alternatives.
No sample application and several links removed from home dashboard.
Backend adapted for Atum template, frontend adapted for Cassiopeia template.
Limited amount of plugins.
Default language is Enlish only, other language can be installed seperately.

Test version:
================

Temporary only the following will be used:
com_fabrik
plg_fabrik_element_field
plg_fabrik_element_internalid
plg_fabrik_element_jdate
plg_fabrik_system

The first goal is to be able to install in J!4, then creat a list with default internalid and jdate and then add a new field element
We do this in the backend only. Next step is the frontend.

If this works, then I will continue with more plugins.

Temporary all files contain a lot of comments that needs to be deleted after all is working.
I just keep it in for debugging purpose.

Build and Install:
================

The build tool may be working here.
Only plugins plg_fabrik_element_field, plg_fabrik_element_internalid, plg_fabrik_element_jdate and plg_fabrik_system should be installed
I did not test this, so no garantee.

I use the easy way:
create a zip-file of each source (com_fabrik, plg_fabrik_element_field, plg_fabrik_element_internalid, plg_fabrik_element_jdate, plg_fabrik_system)
store these in the 'package' folder
create a zip-file of the 'package' folder together with pkg_fabrik.xml
rename the created zip-file to 'fabrik.zip'
install fabrik.zip in a clean joomla 4.x (latest version)

The build tool needs to be modified later, when all is working in J!4

For now I copied my installable fabrik.zip in the fabrik_build folder

Progress:
================

2022-07-01: 
Install is working, only temporary manually install mootools-core.js & mootools-more.js in media\system\js. 
I will change this later, so they are loaded by the WebAssetManager

A new list can be created. 
All other menu items (forms, groups, elements,...) need some updates and may not yet work as expected. 

