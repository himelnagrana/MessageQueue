MessageQueue is a small REST application which deals with managing message queue system. MessageQueue is built
on top of Lemon (https://github.com/phpfour/Lemon). 


Features
========

0.1.9
----
* Update vendor libraries to latest version
* Removed deprecated functions and replaced with latest alternatives
* Updated autoload, logging


0.1
----
* Manage (enqueue, process, dequeue) messages.
* Deals with ASCII and Base64 encoding for sending and recieving message.



Installation
=============
* Clone the repository in your local machine. Install composer and download the
  required dependencies (in the MessageQueue directory):

      curl -s http://getcomposer.org/installer | php
      php composer.phar install

* Create database "messagequeue" and run the sql files (message.sql and queue.sql) from the src/Schema folder

* Copy and rename the "parameter.yml.dist" file to "parameter.yml" and change your preferred persister



API Endpoints
==============

Task                     Method and Route
----------------------  -----------------------------------
Insert message           POST    /message

Get message by id        GET     /message/{messageId}

Update message by id     PUT     /message/{messageId}

Delete message by id     DELETE  /message/{messageId}

Enqueue a message        POST    /queue

Process a message        PUT     /queue/message/{messageId}

Serve next message       GET     /queue/message/{messageId}

Dequeue a message        PUT     /queue/dequeue/{messageId}
