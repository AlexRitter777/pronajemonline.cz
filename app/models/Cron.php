<?php

namespace app\models;

use DateTime;
use pronajem\libs\EmailSender;
use RedBeanPHP\R;

class Cron
{
    /**
     * Calculates and returns a future date based on the specified interval and time units.
     *
     * This method takes an integer representing the interval and a string specifying the time units
     * (e.g., "days", "months", "years") to add to the current date. It then calculates the future date
     * by adding the specified interval of time units to today's date. The resulting date is formatted
     * in "Y-m-d" format and returned as a string.
     *
     * @param int $interval The number of time units to add to the current date.
     * @param string $timeUnits The type of time units to add (e.g., "days", "months", "years").
     * @return string The future date in "Y-m-d" format.
     * @throws \Exception
     */
    protected function getFinishDate(int $interval, string $timeUnits) : string {

        $today = date('Y-m-d');
        $date = new DateTime($today);
        date_add($date,date_interval_create_from_date_string("$interval $timeUnits"));

        return $date->format('Y-m-d');

    }


    /**
     * Sends reminder emails for contracts finishing within a specified interval.
     *
     * This method calculates a future date based on the provided interval and time units,
     * then finds all property records where the 'contract_till' date matches this calculated date.
     * For each property found, it attempts to send a reminder email to the associated user.
     * After processing all relevant properties, it logs the action, including the interval,
     * time units, number of records found, and the number of emails successfully sent.
     *
     * Note: In the context of a cron task, it's essential to explicitly specify the 'from' and 'name'
     * parameters for the email sender, as the default values from the application's configuration
     * container are not available. SMTP is not used for sending emails in this scenario due to the
     * absence of the application's configuration initialization, requiring direct sending through PHPMailer
     * without SMTP configuration. This simplifies email sending in a cron context but necessitates
     * explicit sender information.
     *
     *
     * @param int $interval The number of time units from the current date to calculate the finish date for reminders.
     * @param string $timeUnits The type of time units ('days', 'months', 'years') used for the interval.
     * @throws \Exception Throws an exception if there is a problem with the date calculation.
     */
    public function sendContractFinishRemind(int $interval, string $timeUnits)
    {

        $finishDate = $this->getFinishDate($interval, $timeUnits);
        $properties = R::find('property', ' contract_till = :date ', [':date' => $finishDate]);
        $recordsCount = count($properties);
        $successfullySent = 0;

        if ($properties) {

            $sendMessage = new SendMessage();
            foreach ($properties as $index => $property) {
                $user = R::findOne('users', 'id = ?', [$property->user_id]);
                $result = EmailSender::sendEmail($user->email, 'Pronajemonline.cz - termín ukončení smlouvy', 'contract_finish_email', compact('property', 'user'),'info@pronajemonline.cz', 'pronajemonline.cz');
                if ($result) {
                    $successfullySent++;
                }
            }

        }

        $this->makeLogRecord($interval, $timeUnits, $recordsCount, $successfullySent);

    }


    /**
     * Logs the results of the contract finish reminder sending process.
     *
     *
     * @param int $interval The number of time units from the current date used to identify expiring contracts.
     * @param string $timeUnits The type of time units ('days', 'months', 'years') used for calculating the interval.
     * @param int $recordsCount The total number of property records found that match the finish date.
     * @param int $successfullySent The number of reminder emails successfully sent to users.
     * @return void
     */
    protected function makeLogRecord(int $interval, string $timeUnits, int $recordsCount, int $successfullySent): void
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Interval, {$timeUnits}: {$interval} | Records found: {$recordsCount} | Successfully sent e-mails: {$successfullySent}\n============================\n", 3, ROOT . '/tmp/cron_finish_contract_rem.log');

    }
}