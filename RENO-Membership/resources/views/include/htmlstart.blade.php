<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('https://pas.assalaamhypermarket.co.id//images/logo.png') }}">
    <title>Assalaam PAS Member</title>
  
    
    @vite('resources/css/app.css')
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js') 
    {{-- script --}}
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./assets/js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- script --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.0.0/apexcharts.min.js"
        integrity="sha512-f82EGNY/Wwa6E9g6tKFHoyiaytlgfd0g5gfaOJjSIF6k5T7vqmWrP83iXZdUZoc0DvO3kR4jRpmAZUBt5MhBbA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.0.0/apexcharts.min.css"
        integrity="sha512-e3RSvqXJCnockRd9S0Qe7D2g3Gld0+6Sks/tpU2SGsJrvVHyfTopEf01UHhpGMaoTWqcepzRBKhFqAWJcD8guA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        [x-cloak] {
            display: none !important;
        }
         @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        .animate-pulse-custom {
            animation: pulse 2s infinite;
        }
    </style>
<link href="/src/style.css" rel="stylesheet">
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
   
        function openEditModal(user) {
            document.getElementById('modalUserId').value = user.id;
            document.getElementById('modalUserName').innerText = user.name;
            document.getElementById('modalForm').reset(); // Reset the form fields
            document.getElementById('editPasswordModal').showModal();
        }
    </script>
    @include('include.mode')
</head>

<body class="bg-gray-100 dark:bg-gray-800 font-family-karla flex overflow-x-hidden">
