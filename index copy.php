<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli =  require __DIR__ . "../includes/database.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

// print_r($user['profile_image'])
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="./output.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="app.js"></script>
</head>

<body>






    <!-- nav start -->
    <nav class="bg-zinc-100">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>

                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                  Icon when menu is open.
      
                  Menu open: "block", Menu closed: "hidden"
                -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="index.php"
                            class=" px-3 py-2 text-sm font-semibold text-gray-900"
                            aria-current="page">ABC </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="#"
                                class="rounded-md hover:bg-gray-50   px-3 py-2 text-sm font-medium text-gray-600"
                                aria-current="page">Home</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Team</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Projects</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Calendar</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">


                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <?php if (isset($user)):  ?>



                            <div class="flex justify-center">
                                <div
                                    x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
                                    x-on:keydown.escape.prevent.stop="close($refs.button)"
                                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                    x-id="['dropdown-button']"
                                    class="relative">
                                    <!-- Button -->
                                    <button
                                        x-ref="button"
                                        x-on:click="toggle()"
                                        :aria-expanded="open"
                                        :aria-controls="$id('dropdown-button')"
                                        type="button"
                                        class="relative  items-center  ">
                                        <span><?php echo htmlspecialchars($user["first_name"]) ?></span>

                                        <!-- Heroicon: micro chevron-down -->

                                    </button>

                                    <!-- Panel -->
                                    <div
                                        x-ref="panel"
                                        x-show="open"
                                        x-transition.origin.top.left
                                        x-on:click.outside="close($refs.button)"
                                        :id="$id('dropdown-button')"
                                        x-cloak
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <a href="user-profile.php" class="block px-4 py-2 text-sm  hover:bg-gray-50 text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-0">Profile</a>
                                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50 text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-1">Settings</a>
                                        <a href="logout.php" class="block px-4 py-2 text-sm hover:bg-gray-50 text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-2">Sign out</a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a class="text-white bg-zinc-900  focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center "
                                href="login.php"> <button type="submit" class="">
                                    Sign in </button>
                            </a>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                aria-current="page">Dashboard</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
        </div>
    </div>
    </nav>
    <!-- nav end -->






    <div class=" mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8 ">

        <img class="shadow-lg inline-block rounded-3xl  ring-stone-200 border-4  border-b-stone-600"
            src="assets/image-13.jpg" alt="">
        <div class="absolute ml-[28rem] mt-[-22rem]">
            <p class="text-gray-700 font-semibold text-4xl ">Order your <br>favourite product here </p>
            <p class=" text-gray-600 font-normal text-base pt-1">Order your product now and enjoy delicious meals
                delivered

                hot and fresh right to your doorstep. <br> Fast, easy, convenient your doorstep.
                Fast, easy, convenient! </p>
        </div>


    </div>



    <div class="mx-auto max-w-2xl px-4 mt-8 sm:px-6  lg:max-w-7xl lg:px-8">
        <section class=" antialiased ">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-800 sm:text-2xl">Shop by category</h2>

                    <a href="#" title=""
                        class="flex items-center text-base font-medium text-gray-800 hover:underline dark:text-primary-500">
                        See more categories
                        <svg class="ms-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>
                    </a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50   ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Computer &amp; Office</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50  ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16.872 9.687 20 6.56 17.44 4 4 17.44 6.56 20 16.873 9.687Zm0 0-2.56-2.56M6 7v2m0 0v2m0-2H4m2 0h2m7 7v2m0 0v2m0-2h-2m2 0h2M8 4h.01v.01H8V4Zm2 2h.01v.01H10V6Zm2-2h.01v.01H12V4Zm8 8h.01v.01H20V12Zm-2 2h.01v.01H18V14Zm2 2h.01v.01H20V16Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Collectibles &amp;
                            Toys</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50 ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Books</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50 ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Fashion/Clothes</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50 ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M4.37 7.657c2.063.528 2.396 2.806 3.202 3.87 1.07 1.413 2.075 1.228 3.192 2.644 1.805 2.289 1.312 5.705 1.312 6.705M20 15h-1a4 4 0 0 0-4 4v1M8.587 3.992c0 .822.112 1.886 1.515 2.58 1.402.693 2.918.351 2.918 2.334 0 .276 0 2.008 1.972 2.008 2.026.031 2.026-1.678 2.026-2.008 0-.65.527-.9 1.177-.9H20M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Sports &amp; Outdoors</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7h.01m3.486 1.513h.01m-6.978 0h.01M6.99 12H7m9 4h2.706a1.957 1.957 0 0 0 1.883-1.325A9 9 0 1 0 3.043 12.89 9.1 9.1 0 0 0 8.2 20.1a8.62 8.62 0 0 0 3.769.9 2.013 2.013 0 0 0 2.03-2v-.857A2.036 2.036 0 0 1 16 16Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Painting &amp; Hobby</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 9a3 3 0 0 1 3-3m-2 15h4m0-3c0-4.1 4-4.9 4-9A6 6 0 1 0 6 9c0 4 4 5 4 9h4Z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Electronics</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Food &amp; Grocery</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M20 16v-4a8 8 0 1 0-16 0v4m16 0v2a2 2 0 0 1-2 2h-2v-6h2a2 2 0 0 1 2 2ZM4 16v2a2 2 0 0 0 2 2h2v-6H6a2 2 0 0 0-2 2Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Music</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-5">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">TV/Projectors</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-5">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.041 13.862A4.999 4.999 0 0 1 17 17.831V21M7 3v3.169a5 5 0 0 0 1.891 3.916M17 3v3.169a5 5 0 0 1-2.428 4.288l-5.144 3.086A5 5 0 0 0 7 17.831V21M7 5h10M7.399 8h9.252M8 16h8.652M7 19h10">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Health &amp; beauty</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-5">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Home Air Quality</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-5">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.079 6.839a3 3 0 0 0-4.255.1M13 20h1.083A3.916 3.916 0 0 0 18 16.083V9A6 6 0 1 0 6 9v7m7 4v-1a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4v-6H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1v-6Z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Gaming/Consoles</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Car &amp; Motorbike</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M4 18V8a1 1 0 0 1 1-1h1.5l1.707-1.707A1 1 0 0 1 8.914 5h6.172a1 1 0 0 1 .707.293L17.5 7H19a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z">
                            </path>
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Photo/Video</span>
                    </a>
                    <a href="#"
                        class="border-l-4 border-stone-600 flex items-center rounded-lg border  bg-white px-4 py-2 hover:bg-gray-50 ">
                        <svg class="me-2 h-4 w-4 shrink-0 text-gray-900 dark:text-black" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-700">Security & Wi-Fi</span>
                    </a>
                </div>
            </div>
        </section>
    </div>





    <!-- product start -->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 mt-10 sm:px-6  lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-semibold mb-10 text-gray-800">Popular Products</h2>

            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                <a href="product-overview.html" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/t-shirt.jpg"
                            alt="Tall slender porcelain bottle with natural clay textured body and cork stopper."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Basic Tee 6-Pack</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 1750.00</p>
                </a>
                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-02.jpg"
                            alt="Olive drab green insulated bottle with flared screw lid and flat top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Classic Bread</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 1500.00</p>
                </a>
                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-03.jpg"
                            alt="Person using a pen to cross a task off a productivity paper card."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Paper Refil</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 350.00</p>
                </a>
                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-04.jpg"
                            alt="Hand holding black machined steel mechanical pencil with brass tip and top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Soyas Egg</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 450.00</p>
                </a>

                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-05.jpg "
                            alt="Hand holding black machined steel mechanical pencil with brass tip and top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Sqi Butter</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 550.00</p>
                </a>

                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-06.jpg"
                            alt="Hand holding black machined steel mechanical pencil with brass tip and top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Chilli Pizza</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 999.00</p>
                </a>

                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-08.jpg"
                            alt="Hand holding black machined steel mechanical pencil with brass tip and top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Honey Meet</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 750.00</p>
                </a>

                <a href="#" class="group">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="assets/category-page-04-image-card-07.jpg"
                            alt="Hand holding black machined steel mechanical pencil with brass tip and top."
                            class="h-full w-full object-cover object-center group-hover:border-l-4 border-stone-600">
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">Sushi</h3>
                    <p class="mt-1 text-base font-medium text-gray-900">LKR 1499.00</p>
                </a>






                <div class="space-y-3">


                    <!-- Toast -->
                    <!-- <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label">
                        <div class="flex p-4">
                            <div class="inline-flex items-center justify-center flex-shrink-0">
                                <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                </svg>
                            </div>
                            <div class="ms-3  mr-10">
                                <p id="hs-toast-success-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                                    This is a success message.
                                </p>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Toast -->





                </div>

                <!-- <div id="toast-success"
                    class="flex items-center  max-w-md p-4 mb-4 text-gray-900 bg-white rounded-2xl shadow"
                    role="alert">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                            <g fill="#20c97c" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                <g transform="scale(5.12,5.12)">
                                    <path d="M25,2c-12.69047,0 -23,10.30953 -23,23c0,12.69047 10.30953,23 23,23c12.69047,0 23,-10.30953 23,-23c0,-12.69047 -10.30953,-23 -23,-23zM25,4c11.60953,0 21,9.39047 21,21c0,11.60953 -9.39047,21 -21,21c-11.60953,0 -21,-9.39047 -21,-21c0,-11.60953 9.39047,-21 21,-21zM34.98828,14.98828c-0.3299,0.0065 -0.63536,0.17531 -0.81641,0.45117l-10.20117,15.03711l-7.29102,-6.76562c-0.26069,-0.25084 -0.63652,-0.34135 -0.98281,-0.23667c-0.3463,0.10468 -0.60907,0.38821 -0.68715,0.74145c-0.07809,0.35324 0.04068,0.72112 0.31059,0.96201l8.99609,8.34766l11.51172,-16.96484c0.2153,-0.3085 0.23926,-0.71173 0.06201,-1.04356c-0.17725,-0.33183 -0.52573,-0.53612 -0.90186,-0.5287z"></path>
                                </g>
                            </g>
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="ms-3 text-sm font-semibold">Saved</div>
                    <button type="button"
                        class="ms-auto me-1 mt-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg  p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-4 w-4 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                        data-dismiss-target="#toast-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div> -->





                <!-- More products... -->
            </div>

        </div>
    </div>

    <!-- product end -->


    <!-- footer start -->
    <footer class="bg-zinc-100 rounded-lg shadow m-4 dark:bg-zinc-100">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://flowbite.com/"
                    class="hover:underline">Foodie™</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- footer end -->
    <script src="js/main.js"></script>
</body>

</html>