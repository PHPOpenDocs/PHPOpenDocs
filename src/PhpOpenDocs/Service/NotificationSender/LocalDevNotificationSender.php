<?php

declare(strict_types = 1);

namespace Osf\Service\NotificationSender;

use Osf\Model\PurchaseOrder;
use Osf\Repo\NotificationRepo\PurchaseOrderNotificationRepo;
use Osf\Service\TwilioClient;

class LocalDevNotificationSender implements NotificationSender
{
    /** @var TwilioClient */
    private $twilioClient;

    public function sendNewPurchaseOrderNotification(PurchaseOrder $purchaseOrder)
    {
        $message = sprintf(
            "Holy shit someone raised a purchase order for %s",
            formatPrice(
                $purchaseOrder->getCurrency(),
                $purchaseOrder->getTotalAmount()
            )
        );
        \error_log($message);
    }
}
