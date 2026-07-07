<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/member/profile', 'GET');
// simulate logged in member
$user = App\Models\User::where('role', 'member')->first();
if ($user) {
    $request->setUserResolver(function () use ($user) {
        return $user;
    });
    Auth::login($user);
}
$response = $kernel->handle($request);
echo "STATUS: " . $response->getStatusCode() . "\n";
$content = $response->getContent();
if ($response->getStatusCode() != 200) {
    echo "CONTENT: " . substr($content, 0, 1000) . "\n";
} else {
    echo "SUCCESS\n";
}
