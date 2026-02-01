<?php

INSERT INTO `client_api_data_settings` (`id`, `client_name`, `active`) VALUES (NULL, 'zampila', '0');

ALTER TABLE `languages` ADD `LanguageId` INT NULL DEFAULT NULL AFTER `language_name`;
ALTER TABLE `countries` ADD `LanguageId` INT NULL DEFAULT NULL AFTER `countryID`;
ALTER TABLE `projects` ADD `top_survey` INT NOT NULL DEFAULT '0' AFTER `approved`;