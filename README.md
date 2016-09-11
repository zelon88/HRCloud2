# HRCloud2
A WIP private Cloud Platform.

The HRCloud2 is a personal Cloud Platform that includes all the same functionality as a standard end-user based Cloud platform. With HRCloud2 you can perform all your favorite bash and command line tools just by selecting checkboxes and cliking buttons, from anywhere.

Currently HRCloud2 is a standalone web-framework that DOES REQUIRE WordPress to be installed. THIS IS NOT A WORDPRESS PLUGIN!!! WordPress is only required to create and manage user-accounts.

HRCloud2 DOES NOT directly interact with, or add data to, a database during operation. All log and cache files are internally controlled. HRCloud2 includes a modified version of HRAI, which is still being fully ported to the HRCloud2 platform. When complete, HRAI will be able to load balance (under dev) it's workload between youe other HRAI nodes.


CURRENT CORE FEATURES

-HRCloud2 takes user uploads and stores them in user-specific (but not database driven) non-hosted directories set by the administrator in the config.php file. Files that are requested by the user are temporarily moved to a user-specific hosted directory and are cleaned up every 6 hours. 

-Non-hosted permanent files remain until deleted by the end-user.

-HRCloud2 can upload and manipulate multiple files per request. To download multiple files the user can select files and the archive format of their choosing.

-HRCloud2 can implement various levels of virus scanning depending on server performance and capability. ClamAV is required for A/V support.

-Can archive and dearchive appropriate filetypes (various dependencies to enable support).

-Can convert PDF's, documents, images, audio files, and archive filetypes to other filetypes (various dependencies to enable support).

-Image editing features.

-Copy multiple files.

-Rename multiple files.

-Delete multiple files.

-Quickie PDFTools button button for easy PDF>txt/doc formats and doc/txt>PDF.

-Includes zelon88's HRAI project as a plugin-ready personal assistant (and future load balancer for networked servers).
  
-Accepts some plain speech commands. Go wild and try grammar, punctuation, multiple commands per line ect....
  
-Keeps excellent logs of everything it does.


FUTURE CORE FEATURES

-DocumentScanner similar to Microsoft Office Lens is currently 99% complete, but due to permissions problems isn't ready yet.

-Create/Move files between directories.

-Stream features.

-Search feature.

-Settings page.

