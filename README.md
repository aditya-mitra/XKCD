# XKCD Mailer

A simple PHP app to deliver XKCD comics right into your mailbox.

**Live Demo Link:** http://18.220.47.108/
  
## Problem Statement

```
### 1. Email a random XKCD challenge

Please create a simple PHP application that accepts a visitor’s email address and emails them random XKCD comics every five minutes.

1.  Your app should include email verification to avoid people using others’ email addresses.
2.  XKCD image should go as an email attachment as well as inline image content.
3.  You can visit https://c.xkcd.com/random/comic/ programmatically to return a random comic URL and then use JSON API for details https://xkcd.com/json.html
4.  Please make sure your emails contain an unsubscribe link so a user can stop getting emails.

Since this is a simple project it must be done in core PHP including API calls, recurring emails, including attachments should happen in core PHP. Please do not use any libraries.
```

**Relevant Links:**

- https://learn.rtcamp.com/campus/php-assignments/
- https://learn.rtcamp.com/campus/php-assignments/guidelines/

## Screenshots

<img src="https://i.ibb.co/kGwGmsV/image.png" alt="image" border="0">

<img src="https://i.ibb.co/pvywQk7/image.png" alt="image" border="0">

<img src="https://i.ibb.co/d0pP14k/image.png" alt="image" border="0">

<img src="https://i.ibb.co/qYTJNcj/image.png" alt="image" border="0">
<img src="https://i.ibb.co/crWMshY/image.png" alt="image" border="0">

## Usage

The website is live and can be accessed at http://18.220.47.108/

#### To subscribe and start receiving comics:

1. Enter your email address at the _email address_ input.
2. Now click on the _sign up_ button.
3. If there was an error, the appropriate message will be shown. Otherwise, an verification link will be sent to the email-id.
4. Now, open your inbox and check the corresponding email (It will have the author as _Aditya Mitra_ and the subject as _Please verify your email_). **If you can't find the email in the inbox folder, please check the spam folder.**
5. Now, open the email and click on the verification link in it. Your email is now verified and up for taking emails.

#### To unsubscribe and stop receiving comics:

1. Open any email in which you have received a comic.
2. At the bottom of the email, you can find an underlined _unsubscribe_ link. Click on that link.
3. It will open a new page and ask for your confirmation. Once, you click on _Confirm_ button your email address will deleted from the database and you will not receive any more emails.

### Please Note

- After subscription, XKCD comic will be sent to your mailbox **within the next 5 minutes** (as soon as the scheduler picks up the job).
- Once you or a new email address subscribes, you will receive 7 emails in your inbox. **After this limit, you will not receive any more emails until a new subscriber has been inserted**. I have done this to avoid exceeding the GMail SMTP limits and ensure that the live demo works without friction.
- Since I am using the GMail's SMTP option to send email, there can be a possible delay of _4-5 minutes_ when there are more than a couple of subscribed email-addresses in the database.

## Author

**Aditya Mitra**

**GitHub:** https://github.com/aditya-mitra/

**Portfolio:** https://aditya-mitra.github.io/

**Linkedin:** https://www.linkedin.com/in/aditya--mitra/
