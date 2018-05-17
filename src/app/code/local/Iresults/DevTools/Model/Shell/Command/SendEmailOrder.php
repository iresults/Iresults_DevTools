<?php


class Iresults_DevTools_Model_Shell_Command_SendEmailOrder extends \Iresults\Shell\Command\AbstractCommand
{
    public function execute(
        \Iresults\Shell\InputInterface $input,
        \Iresults\Shell\OutputInterface $output,
        \Iresults\Shell\OutputInterface $errorOutput
    ) {
        if (!$input->hasArgument('order-id')) {
            throw new InvalidArgumentException('Missing argument "order-id"');
        }
        $orderId = $input->getArgument('order-id');
        if (((string)intval($orderId)) !== (string)$orderId) {
            throw new InvalidArgumentException('Argument "order-id" must be an integer');
        }

        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load($orderId);
        if ((string)$order->getId() !== (string)$orderId) {
            throw new InvalidArgumentException(sprintf('No Order with ID %d found', $orderId));
        }
        $order->sendNewOrderEmail();

        $output->writeln('Enqueued the "new order" email for Order #%d', $orderId);
    }

    public static function getName()
    {
        return 'send-email:order';
    }
}
