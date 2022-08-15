@extends('Installer::layout')

@section('step')
<p class="pb-2 font-bold text-gray-800">
    Welcome to the installation wizard.
</p>
<p class="pb-3 text-gray-800">
    <strong>Step 1</strong><br />
    Before getting started, you will need to know your database credentials.
</p>
<div class="px-3 pb-3 text-gray-800">
    <ul class="list-decimal list-inside bg-gray-300 p-4 rounded shadow">
        <li>Database Host</li>
        <li>Database Port</li>
        <li>Database Name</li>
        <li>Database Username</li>
        <li>Database Password</li>
    </ul>
</div>
<p class="pb-3 text-gray-800">
    Most likely these items were supplied to you by your web host.
    If you don’t have this information, then you will need to contact them before you can continue.
</p>
<p class="pb-3 text-gray-800">
    Installer will insert this information inside a configuration file so your site can communicate with your database.
</p>

<p class="pb-3 text-gray-800">
    <strong>Step 2</strong><br />
    After that, the install wizard will ask for the admin email account.
</p>
<!-- <p class="pb-4 text-gray-800">
    Need more help?
    <a class="text-blue-500 hover:underline" href="https://help.mobidonia.com/" target="_blank">See installation guide</a>.
</p> -->
<div class="flex justify-end">
    <a href="{{ route('LaravelInstaller::install.server') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
        Next step
        <svg class="fill-current w-5 h-5 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    </a>
</div>
@endsection