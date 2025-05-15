<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-white-700 shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="/assets/img/homepage_and_book/DentalCareLogo.jpg" alt="Dental Clinic Logo" class="h-10 w-auto">
                <span class="text-2xl font-bold text-blue-600">Dental Care</span>
            </div>

            <nav>
                <ul class="flex space-x-8">
                    <li><a href="#about" class="text-gray-800 hover:text-blue-600 transition">About Us</a></li>
                    <li><a href="#treatments" class="text-gray-800 hover:text-blue-600 transition">Treatments</a></li>
                    <li><a href="#testimonials" class="text-gray-800 hover:text-blue-600 transition">Testimonials</a></li>
                    <li><a href="#contact" class="text-gray-800 hover:text-blue-600 transition">Contact Us</a></li>
                </ul>
            </nav>
    </header>

    <section class="relative bg-cover bg-center h-screen" style="background-image: url('/assets/img/homepage_and_book/cover-bg.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex items-center justify-center h-full text-center text-white px-4">
            <div>
                <h1 class="text-5xl font-bold">Welcome to Our Dental Clinic</h1>
                <p class="mt-4 text-xl">Your smile, our priority</p>
                <a href="<?php echo e(route('book.appointment')); ?>" class="mt-6 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 transition rounded-full">Book Appointment</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 md:px-20 lg:flex lg:gap-16">
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <h3 class="uppercase text-sm font-semibold text-gray-500">ABOUT US</h3>
                <h2 class="mt-2 text-4xl font-bold text-gray-900 leading-tight">
                    Welcome to the Dentist Office of Dr. Chris Gray
                </h2>
                <p class="mt-4 text-lg font-medium text-gray-700">Excellence in Dentistry</p>
                <p class="mt-3 text-gray-600 leading-relaxed">
                    At our clinic, we are dedicated to providing high-quality, patient-focused dental care in a welcoming and professional environment.
                    Our experienced team ensures every visit is comfortable and every smile is treated with the care it deserves.

                    From routine checkups to advanced procedures, we are committed to helping you achieve a healthy, confident smile.
                </p>
            </div>

            <div class="lg:w-1/2 space-y-10">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-blue-500 rounded-full mr-4"></div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800">Everything You Need Under One Roof</h4>
                        <p class="text-gray-600 mt-1">
                            We offer a full range of dental services in our modern, state-of-the-art clinic — from routine cleanings and fillings to advanced procedures like implants and extractions, all under one roof.
                        </p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-blue-500 rounded-full mr-4"></div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800">Our Patient-Focused Approach</h4>
                        <p class="text-gray-600 mt-1">
                            We create personalized treatment plans tailored to your unique needs, lifestyle, and goals. Whether it’s been a few months or several years since your last dental visit, we’re here to help. With a welcoming atmosphere, caring professionals, and gentle, modern treatments, you’ll feel relaxed and confident every step of the way.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="treatments" class="py-20 bg-white">
        <div class="container mx-auto px-4 md:px-20">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-50 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <img src="/assets/img/homepage_and_book/teeth-whitening.svg" alt="Teeth Whitening" class="mx-auto mb-4 h-12" />
                    <h3 class="text-xl font-bold text-gray-800">Teeth Whitening</h3>
                    <p class="mt-2 text-gray-600">Let us show you how our experience.</p>
                    <a href="#" class="mt-4 inline-block text-blue-600 font-medium hover:underline">Read More</a>
                </div>
                <div class="bg-gray-50 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <img src="/assets/img/homepage_and_book/oral-surgery.svg" alt="Oral Surgery" class="mx-auto mb-4 h-12" />
                    <h3 class="text-xl font-bold text-gray-800">Oral Surgery</h3>
                    <p class="mt-2 text-gray-600">Let us show you how our experience.</p>
                    <a href="#" class="mt-4 inline-block text-blue-600 font-medium hover:underline">Read More</a>
                </div>
                <div class="bg-gray-50 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <img src="/assets/img/homepage_and_book/painless-dentistry.svg" alt="Painless Dentistry" class="mx-auto mb-4 h-12" />
                    <h3 class="text-xl font-bold text-gray-800">Painless Dentistry</h3>
                    <p class="mt-2 text-gray-600">Let us show you how our experience.</p>
                    <a href="#" class="mt-4 inline-block text-blue-600 font-medium hover:underline">Read More</a>
                </div>
                <div class="bg-gray-50 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <img src="/assets/img/homepage_and_book/periodontics.svg" alt="Periodontics" class="mx-auto mb-4 h-12" />
                    <h3 class="text-xl font-bold text-gray-800">Periodontics</h3>
                    <p class="mt-2 text-gray-600">Let us show you how our experience.</p>
                    <a href="#" class="mt-4 inline-block text-blue-600 font-medium hover:underline">Read More</a>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 md:px-20">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Patient Testimonials</h2>
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/3">
                        <img src="/assets/img/homepage_and_book/room.jpg" alt="Patient Testimonial" class="rounded-lg w-full">
                    </div>
                    <div class="md:w-2/3">
                        <h3 class="text-xl font-semibold text-blue-600 mb-2">Why choose the Dental Care Center?</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            "The clinic is clean, modern, and comfortable.  The staff are all very professional and friendly.  I've been coming here for years for my regular checkups, and I've always had a great experience."
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            "I was very nervous about getting a root canal, but Dr. Lee and the team made me feel completely at ease.  They explained the procedure thoroughly, answered all my questions, and made sure I was comfortable throughout.  I was amazed at how painless it was!  Thank you!
                        </p>
                        <p class="text-right italic text-gray-600 mt-4">- David C., Smile Makeover Recipient</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-blue-500 py-16 text-white text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-4">Get in touch with us today!</h2>
            <p class="text-lg mb-6">Call us on: +1 562-789-1935</p>
            <a href="<?php echo e(route('book.appointment')); ?>" class="inline-block bg-white text-blue-700 font-bold py-3 px-8 rounded-full hover:bg-blue-100 transition">Book Appointment</a>
        </div>
    </section>

    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Dental Care</h4>
                <p class="text-sm">Providing quality dental care with a gentle touch. We are committed to helping you achieve a healthy and beautiful smile.</p>
                <div class="mt-4">

                </div>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">TREATMENTS</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-gray-400">General Dentistry</a></li>
                    <li><a href="#" class="hover:text-gray-400">Cosmetic Dentistry</a></li>
                    <li><a href="#" class="hover:text-gray-400">Oral Health</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">CONTACT DETAILS</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        1985 Kerry Way, Whittier, CA, PH
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mon - Fri: 9:00 - 19:00<br>Closed on Weekends
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1c-1.657 0-3-1.343-3-3V7c0-1.657 1.343-3 3-3h1a2 2 0 012 2v1c0 1.103-.897 2-2 2h-3.28a1 1 0 01-.948-.684l-1.498-4.493a1 1 0 01.502-1.21L2.257 3.87a11.042 11.042 0 00-5.516-5.516L3.87 2.257a1 1 0 011.21.502l4.493 1.498a1 1 0 01.684.949V5a2 2 0 01-2 2z"></path></svg>
                        +1 562-789-1935
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.224 0L21 8m-6 9V13m0 0l-3-3m3 3l3-3m-3 3l-3 3"></path></svg>
                        dentalcare@gmail.com
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">WE'RE SOCIAL</h4>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="text-gray-300 hover:text-white">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 10-11.6 9.87v-6.99H8v-2.88h2.4V9.41c0-2.37 1.42-3.68 3.6-3.68 1.04 0 2.13.18 2.13.18v2.35h-1.2c-1.18 0-1.55.73-1.55 1.47v1.77H17l-.32 2.88h-2.32v6.99A10 10 0 0022 12z"/>
                      </svg>
                    </a>
                  
                    <a href="https://twitter.com" target="_blank" class="text-gray-300 hover:text-white">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 19c7.5 0 11.6-6.22 11.6-11.6v-.53A8.2 8.2 0 0022 4.9a8.14 8.14 0 01-2.36.65A4.1 4.1 0 0021.4 3a8.19 8.19 0 01-2.6 1A4.09 4.09 0 0012 8.3a11.6 11.6 0 01-8.4-4.3 4.09 4.09 0 001.27 5.46A4 4 0 012 8.8v.05A4.1 4.1 0 005.1 13a4.08 4.08 0 01-1.85.07 4.1 4.1 0 003.84 2.86A8.22 8.22 0 012 17.5a11.62 11.62 0 006 1.76"/>
                      </svg>
                    </a>
                  
                    <a href="https://instagram.com" target="_blank" class="text-gray-300 hover:text-white">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.75 2C5.4 2 3.5 3.9 3.5 6.25v11.5C3.5 20.1 5.4 22 7.75 22h8.5c2.35 0 4.25-1.9 4.25-4.25V6.25C20.5 3.9 18.6 2 16.25 2h-8.5zM12 8a4 4 0 110 8 4 4 0 010-8zm0 1.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5zm5.25-.75a.75.75 0 110 1.5.75.75 0 010-1.5z"/>
                      </svg>
                    </a>
                  
                    <a href="mailto:dentalcare@gmail.com" class="text-gray-300 hover:text-white">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4a2 2 0 01-2-2V6c0-1.1.9-2 2-2zm0 2v.01L12 13 20 6.01V6H4zm0 2.2l7.6 6.1a1 1 0 001.2 0L20 8.2V18H4V8.2z"/>
                      </svg>
                    </a>
                  </div>
                  <p class="mt-4 text-sm text-gray-400"><p>© 2025 DentalCare.<br>All Rights Reserved.</p>
        </div>
    </div>
</footer>
                  <?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/homepage.blade.php ENDPATH**/ ?>