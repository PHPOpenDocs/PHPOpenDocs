<?php

declare(strict_types = 1);

namespace Osf\Service\NotificationSender;

use Osf\Model\PurchaseOrder;
use Osf\Repo\NotificationRepo\PurchaseOrderNotificationRepo;
use Osf\Service\TwilioClient;

class LiveNotificationSender implements NotificationSender
{
    /** @var TwilioClient */
    private $twilioClient;

    /**
     *
     * @param TwilioClient $twilioClient
     */
    public function __construct(TwilioClient $twilioClient)
    {
        $this->twilioClient = $twilioClient;
    }

    public function sendNewPurchaseOrderNotification(PurchaseOrder $purchaseOrder)
    {
        $message = sprintf(
            "Holy shit someone raised a purchase order for %s",
            formatPrice(
                $purchaseOrder->getCurrency(),
                $purchaseOrder->getTotalAmount()
            )
        );

        $this->twilioClient->sendMessage(
            '447473305865',
            $message
        );
    }
}
