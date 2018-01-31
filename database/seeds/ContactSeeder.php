<?php

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contact = new \KW\Transactions\Models\Contact();
        $contact->first_name = 'Joe';
        $contact->last_name = 'Agent';
        $contact->user()->associate(\KW\Transactions\Models\User::where('email','=','admin@kw.com')->first());
        $contact->type()->associate(\KW\Transactions\Models\ContactType::where('name','=','agent')->first());
        $contact->address = '123 Main';
        $contact->email = 'joe.agent@someco.com';
        $contact->postal_code = '75063';
        $contact->state()->associate(\KW\Transactions\Models\State::where('code','=','TX')->first());
        $contact->city()->associate(\KW\Transactions\Models\City::where('name','=','Dallas')->first());
        $contact->save();
        $this->addPhones($contact);

        $contact = new \KW\Transactions\Models\Contact();
        $contact->first_name = 'Fred';
        $contact->last_name = 'Seller';
        $contact->user()->associate(\KW\Transactions\Models\User::where('email','=','admin@kw.com')->first());
        $contact->type()->associate(\KW\Transactions\Models\ContactType::where('name','=','client')->first());
        $contact->address = '567 There';
        $contact->email = 'fred.seller@gmail.com';
        $contact->postal_code = '75094';
        $contact->state()->associate(\KW\Transactions\Models\State::where('code','=','TX')->first());
        $contact->city()->associate(\KW\Transactions\Models\City::where('name','=','Plano')->first());
        $contact->save();
        $this->addPhones($contact);

        $contact = new \KW\Transactions\Models\Contact();
        $contact->first_name = 'Mary';
        $contact->last_name = 'Buyer';
        $contact->user()->associate(\KW\Transactions\Models\User::where('email','=','admin@kw.com')->first());
        $contact->type()->associate(\KW\Transactions\Models\ContactType::where('name','=','client')->first());
        $contact->address = '567 There';
        $contact->email = 'mary.seller@yahoo.com';
        $contact->postal_code = '65012';
        $contact->state()->associate(\KW\Transactions\Models\State::where('code','=','OK')->first());
        $contact->city()->associate(\KW\Transactions\Models\City::where('name','=','Durant')->first());
        $contact->save();
        $this->addPhones($contact);
    }

    protected function addPhones($contact){
        $phone = new \KW\Transactions\Models\ContactPhone();
        $phone->number = '214-123-1234';
        $phone->type()->associate(\KW\Transactions\Models\PhoneType::where('name','=','home')->first());
        $phone->contact()->associate($contact);
        $phone->save();

        $phone = new \KW\Transactions\Models\ContactPhone();
        $phone->number = '972-123-1234';
        $phone->type()->associate(\KW\Transactions\Models\PhoneType::where('name','=','office')->first());
        $phone->contact()->associate($contact);
        $phone->save();

        $phone = new \KW\Transactions\Models\ContactPhone();
        $phone->number = '469-555-1234';
        $phone->type()->associate(\KW\Transactions\Models\PhoneType::where('name','=','mobile')->first());
        $phone->primary = true;
        $phone->contact()->associate($contact);
        $phone->save();
    }
}
