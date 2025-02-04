<template>
    <div class="flex min-h-screen bg-black">
        <!-- Left Section -->
        <div class="hidden md:flex flex-1 items-center justify-center">
            <img src="/images/logo.png" alt="logo">
        </div>

        <!-- Right Section -->
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-16">
            <h1 class="text-4xl font-bold text-white mb-5">Ping...</h1>
            <h2 class="text-2xl font-semibold mt-2 text-white">Join today.</h2>

            <!-- Sign-Up Buttons -->
            <div class="mt-6 space-y-3">
                <button class="w-full py-2 border rounded-lg text-black bg-white hover:bg-gray-200 transition">
                    Sign up with Google
                </button>
                <button class="w-full py-2 border rounded-lg text-black bg-white hover:bg-gray-200 transition">
                    Sign up with Apple
                </button>
                <div class="flex items-center my-2">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-3 text-gray-500">or</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <a href="/register">
                    <button class="w-full py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                        Create Account
                    </button>>
                </a>
                <p class="text-xs text-gray-500 mt-2">
                    By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use
                </p>
            </div>

            <!-- Sign-In Link -->
            <div class="mt-6">
                <p class="text-white pb-3">Already have an account?</p>
                <button class="w-full py-2 border border-blue-500 text-blue-500 font-semibold rounded-lg hover:bg-blue-100 transition">
                    Sign in
                </button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'LandingPage',
}
</script>
