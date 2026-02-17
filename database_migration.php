<?php

ALTER TABLE `vendors` ADD `after_total_complete_link` TEXT NULL DEFAULT NULL AFTER `securityTermlink`, ADD `after_total_disqualify_link` TEXT NULL DEFAULT NULL AFTER `after_total_complete_link`, ADD `after_total_qoutafull_link` TEXT NULL DEFAULT NULL AFTER `after_total_disqualify_link`, ADD `after_total_security_term_link` TEXT NULL DEFAULT NULL AFTER `after_total_qoutafull_link`;
ALTER TABLE `projects` ADD `complete_total_after_redirect` INT NULL DEFAULT NULL AFTER `surveyId`;