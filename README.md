# HRCloud2
A WIP private Cloud Platform.

![HRClou2](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/HRCloud2_0.png)

- **Host your own Cloud Drive and personal assistant from home! From any device!**

- **Upload, download, create, copy, rename and delete multiple files at once!**

- **Convert multiple files at once! Supports most popular documents, images, archives, music and more.**

- **Create Documents (txt, doc, docx, rtf, odf, ect...) from regular images and non-OCR'd PDF's!**

- **Rotate, resize, and convert image files!**

- **Host your own media server!**

- **Excellent logging features!**

- **Create accounts for your friends and family!**

- **Includes HRAI, a WIP personal assistant and application-layer load balancer.**

- **Do all of this with complete control and 100% privacy!**

- **Create API's with standard Ajax or Curl!**

- **Make your own GUI'S!!!!!**

- **SUPPORT DEVELOPMENT BY WRITING SIMPLE PHP, HTML, JSCRIPT, AJAX, CURL, AND CSS!**

- **[FOLLOW THE OFFICIAL YOUTUBE CHANNEL FOR REGULAR UPDATES!] (https://www.youtube.com/playlist?list=PLVbKN4o8V_4OSXI0SGGBMxRvXTZJT3YM_)**

The HRCloud2 is a personal Cloud Platform that includes all the same functionality as a standard end-user based Cloud platform. With HRCloud2 you can perform all your favorite bash and command line tools just by selecting checkboxes and cliking buttons, from anywhere.

Currently HRCloud2 is a standalone web-framework that DOES REQUIRE WordPress to be installed. THIS IS NOT A WORDPRESS PLUGIN!!! WordPress is only required to create and manage user-accounts.

HRCloud2 DOES NOT directly interact with, or add data to, a database during operation. All log and cache files are internally controlled. HRCloud2 includes a modified version of HRAI, which is still being fully ported to the HRCloud2 platform. When complete, HRAI will be able to load balance (under dev) it's workload between youe other HRAI nodes.


CURRENT CORE FEATURES

-HRCloud2 takes user uploads and stores them in user-specific (but not database driven) non-hosted directories set by the administrator in the config.php file. Files that are requested by the user are temporarily moved to a user-specific hosted directory and are cleaned up every 6 hours. 

-Non-hosted permanent files remain until deleted by the end-user.

-HRCloud2 can upload and manipulate multiple files per request. To download multiple files the user can select files and the archive format of their choosing.

-HRCloud2 can implement various levels of virus scanning depending on server performance and capability. ClamAV is required for A/V support.

-Can archive and dearchive appropriate filetypes (various dependencies to enable support).

-Sophisticated process for handling & converting image and pdf files to documents, with or without OCR!

-Can convert almost anything to almost anything else. Including:

   1. pdf TO & FROM jpg/bmp/png/doc/txt/rtf/odf

   2. doc/docx/txt/rtf/pdf TO & FROM doc/docx/txt/rtf/pdf

   3. xls/xls/odf TO  pdf/ods/odf/xls/xls

   4. jpg/bmp/png/gif/pdf TO jpg/bmp/png/gif/pdf/doc/txt/rtf/odf

   5. avi/wav/wma/mp3/mp4/aac/m4a TO & FROM avi/wav/wma/mp3/mp4/aac/m4a

-Image editing features. Including:

   1. Resize

   2. Rotate

   3. Convert

-Copy / Rename / Delete multiple files at once.

-Create / Move files between directories.

-Media Streaming features.

-Search feature.

-Includes zelon88's HRAI project as a plugin-ready personal assistant (and future load balancer for networked servers).
  
-Accepts some plain speech commands. Go wild and try grammar, punctuation, multiple commands per line ect....
  
-Keeps excellent logs of everything it does.

FUTURE CORE FEATURES

-Help Docs!

-More HRAI features!

-Smoother GUI!

-More security!

-Settings page!

![HRClou2](https://raw.githubusercontent.com/zelon88/HRCloud2/384597dc81e6b1fc7c36d89fd7b147cc7ef42b2e/Screenshots/Screenshot_HRCloud2_10_11_16_18.png)

![HRClou2](https://raw.githubusercontent.com/zelon88/HRCloud2/384597dc81e6b1fc7c36d89fd7b147cc7ef42b2e/Screenshots/Screenshot_HRCloud2_10_11_16_14.png)

![HRClou2](https://raw.githubusercontent.com/zelon88/HRCloud2/384597dc81e6b1fc7c36d89fd7b147cc7ef42b2e/Screenshots/Screenshot_HRCloud2_10_11_16_16.png)
