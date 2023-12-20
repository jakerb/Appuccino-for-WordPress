# Appuccino for WordPress
Turns your WordPress site into an App API for Appuccino.

[Wiki](https://github.com/jakerb/appuccino/wiki) 

## Introduction

### What is Appuccino?
Appuccino is a platform for building and maintaining apps for iOS and Android over a CMS system (such as WordPress). Alongside the Appuccino WordPress plugin the core app is designed to manage all aspects of the mobile development workflow and puts app development in the hands of web developers.

### Technologies
Appuccino uses [Angular](https://angularjs.org/) and [UIKit](https://getuikit.com) at its foundation and makes use of the [WPAPI](https://developer.wordpress.org/rest-api/) for delivering content.

### Bugs, Issues & Enhancements
You can view the Wiki [here](https://github.com/jakerb/appuccino/wiki) submit to _Issues_ for support and troubleshooting.

## How to install
Simply download this plugin and copy it into the `plugins` folder of your WP site. Log in to the backend of your site and activate the plugin.

### Quick Check
Once you have successfully installed the WordPress plugin for Appuccino you can perform a quick test to check that it has been configured correctly, simply launch the following URL replacing the `example.com` with your own domain name.

```
https://example.com/wp-json/appuccino/v1/
```

The following should output something similar to:

```json
{
 "namespace":"appuccino/v1",
 "routes": {}
}
```
### Configure Gulp Workflow
The Appuccino WordPress plugin has a Gulp JS/SCSS compile script setup to combine and minify all of your app style and logic. The benefits of using the Gulp workflow means that you can quickly share components and plugins between multiple projects, lint your code in realtime and ensure all resources are as small as possible for transfer to your app.

#### Folder Structure
Your working directory for the Gulp workflow is the `view/source` folder within the plugin. 

|Directory|Description|
|---|---|
|`js/`| All files under this folder are compiled into the `resources/js/script.min.js` file.|
|`js/main.js`|This is the root of your JS code.|
|||
|`plugins/`|All custom plugins are compiled into the `resources/js/script.min.js` file after all files in `js/`.|
|`plugins/helloWorld.js`|An example plugin to help get you started building your own.|
|||
|`scss/`|All files under this folder are compiled into the `resources/css/stylesheet.min.css` file.|
|`scss/style.scss`|The main stylesheet file.|

> _Note_: If you use the Gulp workflow then do _not_ modify the files found in the `resources` folder as these will be overwritten by Gulp.

#### Start Gulp
Open Terminal/Command Prompt on your local machine and navigate to the `source` directory of the Appuccino plugin.

```bash
> cd /path/to/appuccino/view/source
```

The next step is to install NPM dependancies such as Gulp and Uglify, if you do not have NPM/Node.js installed on your machine you can install them [here](https://www.npmjs.com/get-npm).

```bash
> npm install
```
When all dependancies have been successfully installed you will notice a new folder created in your `source` directory called `node_modules` - you can now run Gulp.

```bash
> gulp
```
When Gulp is running any changes you make to a JS/SCSS file will be compiled and displayed in the terminal window. If you create a new plugin or file in the `js` folder you will need to exit Gulp (`CTRL + C`) and restart it.

> If your app required hard-coded constants such as brand colours then you can set these in the `config.js` file in the `config.scss` variable which will be available in your SCSS files.
