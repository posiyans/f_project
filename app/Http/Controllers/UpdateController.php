<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    //
    public function updateDb(){
        $sql=
            [
                'ALTER TABLE `sms` CHANGE `date` `created_at` TIMESTAMP  NOT NULL',
                'ALTER TABLE `sms` CHANGE `sotrud` `worker_id` INT(255) NOT NULL',
                'ALTER TABLE `sms` CHANGE `cena` `price` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL',
                //миграция таблицы file
                'ALTER TABLE `file` CHANGE `diagnoz` `med_diagnosis_id` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `file` CHANGE `deistv` `med_actions_id` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `file` CHANGE `sotrudn` `worker_id` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `file` CHANGE `schet` `med_invoice_id` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `file` CHANGE `date` `created_at` TIMESTAMP NULL DEFAULT NULL',
                'ALTER TABLE `file` CHANGE `del` `deleted_at` TIMESTAMP NULL DEFAULT NULL',
                'RENAME TABLE `gmo`.`file` TO `gmo`.`files`',
                'ALTER TABLE `firm` CHANGE `petern` `parent` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `firm` CHANGE `small_name` `name_small` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'RENAME TABLE `gmo`.`firm` TO `gmo`.`firms`',
                'RENAME TABLE `gmo`.`diagnoz` TO `gmo`.`diagnoses`',
                'ALTER TABLE `diagnoses` CHANGE `data` `created_at` TIMESTAMP NOT NULL',
                'ALTER TABLE `diagnoses` CHANGE `diagnoz` `mkb_id` INT(255) NOT NULL',
                'ALTER TABLE `diagnoses` CHANGE `sotrud` `worker_id` INT(255) NOT NULL',
                'ALTER TABLE `diagnoses` CHANGE `file` `file_id` INT(255) NOT NULL',
                'ALTER TABLE `diagnoses` CHANGE `galob` `complaint_id` INT(255) NOT NULL',
                'ALTER TABLE `mkb` DROP `xesh`',
                'RENAME TABLE `gmo`.`mkb` TO `gmo`.`mkbs`',
                'RENAME TABLE `gmo`.`galoba` TO `gmo`.`complaints`',
                'ALTER TABLE `complaints` CHANGE `sotrudn` `worker_id` INT(255) NOT NULL',
                'ALTER TABLE `complaints` CHANGE `date_time` `created_at` DATETIME NOT NULL',
                'ALTER TABLE `complaints` CHANGE `galoba` `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL',
                'ALTER TABLE `complaints`
                    DROP `deistv`,
                    DROP `prim`,
                    DROP `data_deistv`',
                'RENAME TABLE `gmo`.`deistv` TO `gmo`.`med_actions`',
                'ALTER TABLE `med_actions` CHANGE `data` `data` DATETIME NULL',
                //'UPDATE `med_action` SET `data` = NULL WHERE `med_action`.`data` = \'0000-00-00 00:00:00\'',
                //'ALTER TABLE `med_action` CHANGE `data_deistv` `created_at` TIMESTAMP NULL DEFAULT NULL',
                'ALTER TABLE `med_actions` CHANGE `id_galob` `complaint_id` INT(255) NOT NULL',
                'ALTER TABLE `med_actions` CHANGE `type_deistv` `action_type_id` INT(255) NOT NULL',
                'ALTER TABLE `med_actions` CHANGE `schet` `invoice_id` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `med_actions` CHANGE `rub` `money` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL',
                'ALTER TABLE `med_actions` CHANGE `data_deistv` `created_at` DATETIME NOT NULL',
                'ALTER TABLE `med_actions` CHANGE `lpy` `lpy_id` INT(11) NULL DEFAULT NULL',
                'RENAME TABLE `gmo`.`lpi` TO `gmo`.`lpies`',
                'ALTER TABLE `lpies` CHANGE `file` `file_id` INT(255) NULL DEFAULT NULL',
                'UPDATE `lpies` SET `file_id` = NULL',
                'RENAME TABLE `gmo`.`schet` TO `gmo`.`invoices`',
                'ALTER TABLE `invoices` CHANGE `data_post` `created_at` DATETIME NOT NULL',
                'ALTER TABLE `invoices` CHANGE `nomer_cheta` `nomber` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL',
                'ALTER TABLE `invoices` CHANGE `lpy` `lpy_id` INT(255) NULL DEFAULT NULL',
                'RENAME TABLE `gmo`.`status` TO `gmo`.`statuses`',
                'RENAME TABLE `gmo`.`sotrud` TO `gmo`.`workers`',
                'ALTER TABLE `workers` DROP `firm`',
                'ALTER TABLE `workers` DROP `firm_1c`',
                'ALTER TABLE `workers` CHANGE `firm_int` `firm` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `workers` CHANGE `firm_1c_int` `firm_1c` INT(255) NULL DEFAULT NULL',
                'ALTER TABLE `med_actions` CHANGE `lpy` `lpy_id` INT(11) NULL DEFAULT NULL',
                'ALTER TABLE `workers` CHANGE `obnow` `obnov` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL',
                'ALTER TABLE `workers` CHANGE `status` `status_id` INT(10) UNSIGNED NULL DEFAULT NULL',
                'ALTER TABLE `workers` CHANGE `status_1c` `status_1c_id` INT(10) UNSIGNED NULL DEFAULT NULL',
            ];


        foreach ($sql as $sq){
            echo $sq."<br>";
            dump(DB::unprepared($sq));
            DB::commit();
        }
        $this->seedData();



    }
    public function seedData(){
        DB::unprepared("INSERT INTO `action_types` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
        (1, 'Другое', 0, NULL, NULL),
        (2, 'Консультация', 0, NULL, NULL),
        (3, 'Плановая госпитализация', 0, NULL, NULL),
        (4, 'Амбулаторная помощь', 0, NULL, NULL),
        (5, 'Экстренная госпитализация', 0, NULL, NULL),
        (6, 'Скорая помощь', 0, NULL, NULL),
        (7, 'Плановая госпитализация(ОМС)', 1, NULL, NULL),
        (8, 'Амбулаторная помощь(ОМС)', 1, NULL, NULL),
        (9, 'Экстренная госпитализация(ОМС)', 1, NULL, NULL),
        (10, 'Скорая помощь(ОМС)', 1, NULL, NULL)");

        DB::unprepared("INSERT INTO `med_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
        (1, 'Admin', NULL, NULL),
        (10, 'Медики', NULL, NULL),
        (20, 'Терапевт', NULL, NULL),
        (100, 'Диспетчер', NULL, NULL)");

    }

}
