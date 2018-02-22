<?php

namespace App\Console\Commands;

use App\{PurchasedDomain, HostingContract};
use Illuminate\Console\Command;

class SendRenewalEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo electrónico de renovación.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $purchasedDomains = PurchasedDomain::with('domainProvider:id,company_name')->get();
      $hostingContracts = HostingContract::with('customer:id,first_name,last_name,company_name')->get();
      foreach ($purchasedDomains as $purchasedDomain)
      { 
        if ( $purchasedDomain->isDayToSendRenewalEmail() ) {
          $purchasedDomain->sendRenewalEmailTo('programador@dimacros.net');
          $this->info('¡Correo electrónico enviado exitosamente!');
        }
        elseif ( $purchasedDomain->isExpired() ) {
          $this->info('Dominio hosting expirado.');
          $purchasedDomain->status = 'expired';
          $purchasedDomain->save();
        }
      }
      foreach ($hostingContracts as $hostingContract)
      { 
        if ( $hostingContract->isDayToSendRenewalEmail() ) {
          $hostingContract->sendRenewalEmailTo('programador@dimacros.net');
          $this->info('¡Correo electrónico enviado exitosamente!');
        }
        elseif ( $hostingContract->isExpired() ) {
          $this->info('Contrato Hosting vencido.');
          $hostingContract->status = 'finished';
          $hostingContract->save();
        }
      }
    }
}