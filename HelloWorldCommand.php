<?php
namespace Dekanac;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this->setName('btc:price')
            ->setDescription('Outputs \'Bitcoin price\'');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $endpoint = "https://api.coinpaprika.com/v1/tickers";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        $bitcoinPrice = floatval($responseData[0]['quotes']['USD']['price']);
        $bitcoinPrice = number_format($bitcoinPrice, 2);

        $output->writeln("\033[0;45mThe current price of Bitcoin is \033[0m \033[0;33m $" . $bitcoinPrice." \033[0m");
        return 0;
    }
}
