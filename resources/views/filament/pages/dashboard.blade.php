<x-filament-panels::page>
    <style>
        /* Container */
        .page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

        }

        @media (prefers-color-scheme: dark) {
            .page-container {
                background-color: #111827;
            }
        }

        /* Clock */
        .clock {
            font-size: 2.25rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }
        @media (prefers-color-scheme: dark) {
            .clock {
                color: #e5e7eb;
            }
        }
        @media (prefers-color-scheme: dark) {
            .lock-box {
                background-color: #1f2937;
                border-color: #374151;
            }
        }

        @media (prefers-color-scheme: dark) {
            .user-name {
                color: #d1d5db; /* dark:text-gray-300 */
            }
        }

        /* Avatar */

        .avatar .image{
            /*margin:10px auto ;*/
            width: 100%;
            height: 100%;
            /*padding: 10px;*/

        }
        @media (prefers-color-scheme: dark) {
            .avatar {
                border-color: #4b5563; /* dark:border-gray-600 */
            }
        }

        /* Welcome text */
        .welcome-text {
            font-size: 1.125rem; /* text-lg */
            color: #4b5563; /* text-gray-600 */
            font-weight: 900;
        }
        @media (prefers-color-scheme: dark) {
            .welcome-text {
                color: #9ca3af; /* dark:text-gray-400 */
            }
        }
        .lock-box {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border-radius: 10px;
            padding: 1rem 2rem;
            margin: 2rem auto;
            text-align: center;
            border: 1px solid #e5e7eb;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }
        .user-name {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
        }

        .avatar {
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border-radius: 50%;
            /*padding: 5px;*/
            width: 150px;
            height: 150px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .fi-page-main{
            height: 60vh !important;
            display: flex !important;
        }
    </style>
    <div class="page-container">
        <script type="text/javascript">
            window.onload = function() {
                startTime();
            }
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
                setTimeout(startTime, 1000); // update every 1 second
            }

            function checkTime(i) {
                return i < 10 ? "0" + i : i;
            }
        </script>

        <!-- Clock -->
        <div id="time" class="clock"></div>

        <!-- Lock Box -->
        <div class="lock-box">
            <div class="welcome-text">Welcome</div>
            <div class="avatar">
                <img src="{{ asset('assets/images/logo.PNG') }}"
                     alt="lock avatar"
                     class="image"/>
            </div>
            <div class="welcome-text">
                {{ Auth::user('admin')->username }}
            </div>
        </div>
    </div>
</x-filament-panels::page>


