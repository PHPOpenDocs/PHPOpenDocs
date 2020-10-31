<?php

declare(strict_types = 1);

namespace Osf\Service\NotificationSender;

use Osf\Model\PurchaseOrder;

interface NotificationSender
{
    public function sendNewPurchaseOrderNotification(PurchaseOrder $purchaseOrder);
}
