# Jarvis Bot Messenger - version 1.0.0

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Jarvis is Facebook Compliant Messenger Bot For Facebook Messenger.

see [Messenger Policy Overview](https://developers.facebook.com/policy#messengerplatform)

It Uses Facebook Messenger API, That Allows our Users to Easily Create Their Own Messenger Bot...

Without Any Knowledge or Coding Skills...

Without the Trouble of Submitting your App For Review...

It Allows You To Utilize Majority of Facebook Messenger API

It is Simple as...

- Create an Account / Sign Up with Social Media Account...
- Verify Email
- Free Trial Access
- Run Newly SignUp Wizard / Tour ...
- Create a Bot ...
- Create Your Flows or Import From Our Flows Library...
- Connect Your Fanpage...
- Start Sending Message...
- Keep Sending Messages to your Subscribers
- Refine Your Bot Interactions

The Possibilities are Endless... You Can Experiment With Our Apps...
Creating Different Types of Responds or Have a Easy Import Of the Type of Responses / Flows You Want...

##### Send API

- Sender Actions
- Text Message
- Image Attachment
- Audio Attachment
- Video Attachment
- File Attachment
- Generic Template
- Button Template
- ~~Receipt Template~~
- Quick Replies
- ~~Airline Itinerary Template~~
- ~~Airline Checkin Template~~
- ~~Airline Boarding Pass Template~~
- ~~Airline Flight Update Template~~

##### Thread Settings
- Greeting Text
- Get Started Button
- Persistent Menu
- ~~Account Linking~~

##### Payment API
- ~~Payment Beta~~

##### User Profile Reference
- first_name
- last_name
- profile_pic (note: add this in migrations)
- locale
- timezone
- gender

##### Ways to Interact with Bot
- Messenger Code
- ~~Message Us Plugin~~
- ~~Send to Messenger~~
- Messenger Link


### Security Optimization

- [x] SSL A+ Encryption
- [x] Social Auth
  - [x] Facebook
  - [x] Twitter
  - [x] Google+
- [x] Email Verification
- [x] Recaptcha (Anti-Spam)


### All Things You Can Do With Jarvis
- [x] Manage Account
    - [x] Change Name
    - [x] Change Password
    - [x] Delete Account
    - [x] Enable /Disable Google 2 Factor Authentication
- [x] CRUD Bot
- [x] Connect Bot with Fanpage
- [x] Analytics On Message Sent/Fail
- [x] CRUD Flows
- [x] Import and Export Flows
- [x] Set General Settings
    - [x] Update Bot name
    - [x] Time Zone For Fanpage (Cron)
- [x] Set Thread Settings
    - [x] Set Greeting Message
    - [x] Set Get Started  Button
    - [x] Set Persistent Menu
- [x] List All Recipients
- [x] Analytics for Sending Message to Recipients
- [x] CRUD Recipient Variables default('first_name', 'last_name', 'gender', 'locale', 'timezone')
- [x] CRUD Responds plus Search by Title
- [x] MASS Messages (Broadcast/Instant)
- [x] MASS Messages Analytics
- [x] Scheduled MASS Messages
- [x] CRUD Channels
- [x] Channels Analytics

### Types of Responds
- [x] Messages
    - [x] File
    - [x] Audio
    - [x] Text
    - [x] Image
    - [x] Carousel
    - [x] Quick Replies
    - [x] Video
    - [x] Buttons
- [x] Plugins (Third Party Integration)
    - [x] RSS Feed (Blogs)
    - [x] CallBack (External Sites via JSON)
- [x] Hooks
    - [x] Ping Url
    - [x] Save Input To User Variables
    - [x] Toggle Chat (ON/OFF)
    - [x] Subscribe to a Channel

### Administrative Functionalities
- [x] Manually Activate Paid Users
- [x] CRUD Users
- [x] Impersonate User
- [x] List All Users

### TODO for Version 1.5.0

- [ ] Middleware for Premium Subscriber
- [ ] Free Trial Period
- [ ] Manually/Auto Activate Paid Users
- [ ] Add Payment Gateway For Admin
- [ ] Middleware for New Sign Up Tour

### TODO for Version 2.0.0

- [ ] Add Receipt Template for Users (Business Package)
- [ ] Add Product , Categories, Cart and Orders to Users (Business Package)
- [ ] Add Many Payment Gateway for Users to Accept Payments
    - [ ] Offline
    - [ ] Paypal
    - [ ] Stripe
    - [ ] 2CheckOut
    - [ ] ETC.
- [ ] Customer One time Payment / Subscription Type Payment

### Facebook Guidelines

Please Read [Facebook Guidelines Pages](https://developers.facebook.com/docs/messenger-platform/guidelines)
### Jarvis Tutorial

Please Visit Our Official Youtube Channel [Jarvis Bot Messenger](https://www.youtube.com/channel/UCDh23Q5AWaDMCutt3bS54nQ).


### Server Side Requirement Needed For Invoice
- [x] PHP7
- [x] php7.0-gd
- [x] php7.0-intl

### Additioanl Server Extension
- [x] PHP7 Redis

### Set Up to Process Background Jobs
- [x] php artisan messages:schedules:process
- [x] php artisan broadcasts:schedules:process
