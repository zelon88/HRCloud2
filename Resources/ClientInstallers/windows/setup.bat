ECHO OFF
CLS
:MENU
ECHO v1.0
ECHO ...............................................
ECHO WELCOME TO THE HRCLOUD2-CLIENT INSTALLER FOR WINDOWS!
ECHO PRESS  Y  TO INSTALL HRCLOUD2. PRESS  N  TO EXIT
ECHO ...............................................
ECHO.
ECHO Y - Install HRCloud2-Client
ECHO N - EXIT
ECHO.
SET /P M=Type Y or N, then press ENTER:
IF %M%==Y GOTO INSTALL
IF %M%==N GOTO EOF

:INSTALL
ECHO CREATING DIRECTORUIES!
mkdir "C:\Program Files\HRCloud2"
ECHO COPYING FILES!
xcopy *.* "C:\Program Files\HRCloud2" /s 
ECHO CREATING SHORTCUTS!
powershell "$s=(New-Object -COM WScript.Shell).CreateShortcut('C:\ProgramData\Microsoft\Windows\Start Menu\Programs\HRCloud2-Client.lnk');$s.TargetPath='C:\Program Files\HRCloud2\HRCloud2-Client.exe';$s.Save()"
powershell "$s=(New-Object -COM WScript.Shell).CreateShortcut('%userprofile%\Desktop\HRCloud2-Client.lnk');$s.TargetPath='C:\Program Files\HRCloud2\HRCloud2-Client.exe';$s.Save()"
ECHO INSTALLATION COMPLETE!
PAUSE
EXIT /B

GOTO MENU
EXIT /B