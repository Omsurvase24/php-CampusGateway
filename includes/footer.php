    <div>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        alertify.set('notifier','position', 'top-right');
        <?php
            if(isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                $text = $_SESSION['message']['text'];
                $type = $_SESSION['message']['type'];
                
                if($type == 'success') {
                ?>
                    alertify.success('<?= $text;?>');
                <?php
                }
                else {
                ?>
                    alertify.error('<?= $text;?>');
                <?php
                }

                unset($_SESSION['message']);
            }
        ?>
    </script>
</body>
</html>