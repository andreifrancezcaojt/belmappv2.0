<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            flex-direction: column;
        }

        .panes-wrapper {
            display: flex;
            height: 100%;
            flex-direction: row;
        }

        .pane {
            border: none;
            height: 100%;
        }

        .left-pane {
            flex: 2; /* Smaller portion */
            border-right: 2px solid #ddd;
        }

        .right-pane {
            flex: 3; /* Larger portion */
        }

        /* Mobile-specific layout */
        @media (max-width: 768px) {
            .panes-wrapper {
                flex-direction: column;
            }

            .pane {
                flex: 1 100%;
                height: 100%;
            }

            .pane.hidden {
                display: none;
            }

            .pane.visible {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="panes-wrapper">
        <!-- Left pane for threads -->
        <iframe class="pane left-pane visible" src="thread.php" name="left_frame"></iframe>
        <!-- Right pane for viewing a thread -->
        <iframe class="pane right-pane hidden" src="view_thread.php" name="right_frame"></iframe>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const leftPane = document.querySelector('.left-pane');
            const rightPane = document.querySelector('.right-pane');

            // Listen for "navigateToView" messages from thread.php
            window.addEventListener('message', (event) => {
                if (event.data === 'navigateToView') {
                    leftPane.classList.remove('visible');
                    leftPane.classList.add('hidden');
                    rightPane.classList.remove('hidden');
                    rightPane.classList.add('visible');
                }
            });

            // Expose a function to navigate back to threads
            window.navigateToThreads = () => {
                leftPane.classList.remove('hidden');
                leftPane.classList.add('visible');
                rightPane.classList.remove('visible');
                rightPane.classList.add('hidden');
            };
        });
    </script>
</body>

</html>
