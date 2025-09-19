<?php

if (!file_exists('data')) mkdir('data');
if (!file_exists('data/bookings.csv')) file_put_contents('data/bookings.csv', "name,email,plan,date\n");
if (!file_exists('data/feedback.csv')) file_put_contents('data/feedback.csv', "name,email,message,date\n");
?>
