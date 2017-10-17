**[OFFICIAL WEBSITE! (Try HRCloud2)](https://honestrepair.net)**

**[YOUTUBE CHANNEL!](https://www.youtube.com/playlist?list=PLVbKN4o8V_4OSXI0SGGBMxRvXTZJT3YM_)**

**[WIKI DOCUMENTATION!](https://github.com/zelon88/HRCloud2/wiki)**

# HRCloud2
A **Fully Featured** home-hosted **Cloud Storage** platform and **Personal Assistant** that **Converts files, OCR's images & documents, Creates archives, Scans for viruses, Protects your server, Keeps itself up-to-date,** and **Runs your own AppLauncher!** 

# Screenshots
### [More Screenshots](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/More_Screenshots.md)
![HRCloud2](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/HRCloud2_11-17-16_0.png)	
![HRCloud2](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/HRCloud2_11-17-16_23.png)	
![HRCloud2](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/HRCloud2_5-7-17_1.png)
![HRCloud2](https://github.com/zelon88/HRCloud2/blob/master/Screenshots/HRCloud2_8_10_17.png)	


# A Secure, Private Cloud Storage Platform for your Home Server!

HRCloud2 is a personal Cloud CMS Platform similar to ownCloud but with far greater capability that includes all the same functionality as a commercial end-user based Cloud platform. Functions like file conversion, OCR, archiving, dearchiving, A/V scanning, sharing and more. With HRCloud2 you can perform all your favorite bash and command line tools just by selecting checkboxes and clicking buttons, from anywhere. 

HRCloud2 can integrate with WordPress, althogh it will install what it needs from WordPress when it does not exist. It uses user accounts created by WordPress, but does not itself use a database for anything other than user authentication. All log and cache files are internally controlled. HRCloud2 also includes a modified version of HRAI, which is still being fully ported to the HRCloud2 platform. When complete, HRAI will be able to load balance (under dev) it's workload between your other HRAI nodes.

# CURRENT CORE FEATURES

-Takes user uploads and stores them in user-specific (but not database driven) non-hosted directories set by the administrator in the config.php file. Files that are requested by the user are temporarily moved to a user-specific hosted directory or symlinks are created and cleaned every 10 minutes. 

-Supports unlimited number of users. User storage, cache, and log files are automatically created the first time a new user logs in. Uses built-in WordPress for account creation and management.

-Non-hosted permanent files remain until deleted by the end-user.

-Can upload and manipulate multiple files per request. To download multiple files the user can select files and the archive format of their choosing.

-Can implement various levels of virus scanning depending on server performance and capability. ClamAV is required for A/V support.

-Can archive and dearchive appropriate filetypes (various dependencies to enable support).

-Can convert document, image, audio, 3d model, presentation (slideshow/pages), and archive filetypes to other filetypes (various dependencies to enable support).

-Image editing features (rotate, resize, convert. API for maintain A/R).

-Copy multiple files.

-Rename multiple files.

-Delete multiple files.

-User Selectable Skins & Color Schemes.

-Includes zelon88's HRAI project as a plugin-ready personal assistant (and future load balancer for networked servers).
  -Accepts some plain speech commands. Go wild and try grammar, punctuation, multiple commands per line ect....
  
-Keeps excellent logs of everything it does.

-Stream & Playlist features. (Alpha)

-Users can view and launch Apps from their AppLauncher.

-Share files with other users or the public.

-Admins can automatically install Apps from .zip files or uninstall them just as easily.

-Includes "Notes", "Contacts", and "Calculator" apps by zelon88.

-Includes "Grabber" App by zelon88 for downloading files from URL straight to your Cloud Drive.

-Includes "ServStat" App for admins that allows monitoring of local or remote servers.

-Includes "ServMonitor" App for real-time monitoring of server utilization, status, and specs (including CPU, RAM, Temp(s), Battery, Power Status, and more specs than your device manager could shake a stick at!

-Includes "PHP-AV" App, a server-side anti-virus, anti-malware app that admins can use to scan their server. Written in PHP, this app can target ANY file or folder on the server, or intelligently scans HRCloud2-related files with a single click.

-Automatic Updates (downloads latest updates from Github and installs itself).

-Clear user / master cache option.

-Clipboard (copy/paste files, folders, items between locations).

-Build your own desktop client app from the Settings page. Compatible with Windows, Linux, and MacOS.

# RUNS ON

-Any x86 or x64 PC that meets the [Dependency Requirements](https://github.com/zelon88/HRCloud2/wiki/Dependency-Requirements).

-Raspberry Pi and other linux-capable maker-boards.

-Compatible with CDN's, multi-domain's, reverse-proxies, multi-server's (single domain or multi-domain), WordPress multi-site, or any combination thereof.

-Compatible with any storage medium. Including removable devices,  virtual machines (VM's), network storage (and NAS devices), RAID arrays, or conventional storage.

# FUTURE CORE FEATURES

-New features, bug fixes, and improvements several times weekly!!!
-Working on "Teams" App so you can finally uninstall Slack!

# Want more?

Check out the official [Wiki](https://github.com/zelon88/HRCloud2/wiki).

----------------------------

[![HRCloud2](https://www.openhub.net/p/HRCloud2/widgets/project_partner_badge?format=gif&ref=samplg)](https://www.openhub.net/p/HRCloud2)

Think our project is neat? Support us on Flattr!
[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=zelon88&url=https://github.com/zelon88/HRCloud2&title=HRCloud2&language=&tags=github&category=software)  

**[Official (hosted in-house) Download Mirror!](https://honestrepair.net/HRProprietary/Distros/HRCloud2-master.zip)**

<3 Open-Source.

[HRCloud2](http://hrcloud2.com)
by [HonestRepair](https://www.HonestRepair.net)
