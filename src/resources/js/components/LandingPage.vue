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
                <white-button>
                    Sign up with Google
                </white-button>
                <white-button>
                    Sign up with Apple
                </white-button>

                <div class="flex items-center my-2">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-3 text-gray-500">or</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <!-- Register Button-->
                <a href="/register">
                    <indigo-button>
                        Create Account
                    </indigo-button>
                </a>
                <p class="text-xs text-gray-500 mt-2">
                    By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use
                </p>
            </div>

            <!-- Sign-In Link -->
            <div class="mt-6">
                <p class="text-white pb-3">Already have an account?</p>
                <a href="/login">
                    <indigo-button>
                        Sign in
                    </indigo-button>
                </a>

            </div>

        </div>
    </div>
</template>

<script>
    import WhiteButton from "./ui/WhiteButton.vue";
    import IndigoButton from "./ui/IndigoButton.vue";

    export default {
        name: 'LandingPage',
        components: {IndigoButton, WhiteButton},
    }
</script>
