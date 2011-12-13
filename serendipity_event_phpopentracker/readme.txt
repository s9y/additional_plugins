Thanks for downloading!

This is a plugin that enables s9y to log accesses via PHPOpenTracker.

Install
1. You need PHPOpenTracker properly installed in a secure place (See http://www.phpopentracker.de for download and installation instructions). Configure a client_id in 'conf/phpopentracker.php' of your working PHPOpenTracker installation (somewhere at the bottom of the file). If you don't have PHPOpenTracker installed you can configure the plugin to use a web bug (see phpOpenTracker for more information).

2. Once installed, extract s9y_plugin_phpopentracker-X.XX.tar.bz2 to the plugins dir of s9y.

3. Go to the s9y admin interface and enable the plugin. Enter the client_id that you have entered in the PHPOpenTracker config file and the directory path to your PHPOpenTracker installation OR enter the URL of the web bug in the web bug form field. You should leave the file name setting alone unless you have renamed file phpOpenTracker.php. Save and you are done.

If nothing is being logged, check for an all-numeric client ID and that POT has been installed correctly. Check path and file name in the admin interface also.

BSD license, Copyright (c) 2005, Rene Schmidt - http://log.reneschmidt.de/
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the copyright owner nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

History:
1.3
- enabled the plugin to use web bugs (see PHPOpenTracker docs)
1.2
- config value checks after saving from admin interface
- sped up plugin execution process a bit
1.1
- pot path and file name customisable via admin interface
- only accept numeric client ID
1.0
- initial release
