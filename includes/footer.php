<?php
/**
 * فوتر مشترک — لینک‌های فرعی (اطلاعاتی) به صفحات واقعی instagram.com / meta.com.
 * هیچ‌کدام از این لینک‌ها به فرآیند لاگین/ثبت‌نام این اپ مربوط نیستند و فقط
 * کاربر را به صفحات رسمی و عمومی شرکت متا هدایت می‌کنند.
 */
$footer_links = [
    'Meta'                         => 'https://about.meta.com/',
    'About'                        => 'https://about.instagram.com/',
    'Blog'                         => 'https://about.instagram.com/blog',
    'Jobs'                         => 'https://about.instagram.com/about-us/careers',
    'Help'                         => 'https://help.instagram.com/',
    'API'                          => 'https://developers.facebook.com/docs/instagram',
    'Privacy'                      => 'https://privacycenter.instagram.com/policy/',
    'Terms'                        => 'https://help.instagram.com/581066165581870',
    'Locations'                    => 'https://www.instagram.com/explore/locations/',
    'Instagram Lite'               => 'https://www.instagram.com/accounts/login/?next=%2Flite%2F',
    'Threads'                      => 'https://www.threads.net/',
    'Contact Uploading & Non-Users'=> 'https://help.instagram.com/581066165581870',
    'Meta Verified'                => 'https://about.meta.com/technologies/meta-verified/',
];
?>
<footer>
  <div class="footer-links">
    <?php foreach ($footer_links as $label => $url): ?>
      <a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
        <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="lang-select">
    <select disabled>
      <option>English</option>
    </select>
  </div>
  <div>&copy; <?php echo date('Y'); ?> Instagram UI Clone (Demo) &mdash; footer links point to the real instagram.com / meta.com</div>
</footer>
