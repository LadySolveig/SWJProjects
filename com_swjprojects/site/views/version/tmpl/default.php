<?php
/**
 * @package    SW JProjects Component
 * @version    1.0.2
 * @author     Septdir Workshop - www.septdir.com
 * @copyright  Copyright (c) 2018 - 2018 Septdir Workshop. All rights reserved.
 * @license    GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link       https://www.septdir.com/
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::stylesheet('media/com_swjprojects/css/site.min.css', array('version' => 'auto'));
?>
<div id="SWJProjects" class="version">

	<div class="version info well">
		<h1>
			<?php echo $this->version->title; ?>
		</h1>
		<div class="meta">
			<ul class="inline">
				<li>
					<strong><?php echo Text::_('COM_SWJPROJECTS_PROJECT'); ?>: </strong>
					<a href="<?php echo $this->project->link; ?>">
						<?php echo $this->project->title; ?>
					</a>
				</li>
				<li>
					<strong><?php echo Text::_('COM_SWJPROJECTS_CATEGORY'); ?>: </strong>
					<a href="<?php echo $this->category->link; ?>">
						<?php echo $this->category->title; ?>
					</a>
				</li>
			</ul>
			<div class="buttons">
				<a href="<?php echo $this->version->download; ?>" class="btn btn-success" target="_blank">
					<?php echo Text::_('COM_SWJPROJECTS_DOWNLOAD'); ?>
				</a>
				<?php if ($urls = $this->project->urls->toArray()): ?>
					<?php foreach ($urls as $txt => $url):
						if (empty($url)) continue; ?>
						<a href="<?php echo $url; ?>" target="_blank" class="btn">
							<?php echo Text::_('COM_SWJPROJECTS_URLS_' . $txt); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="changelog">
		<?php foreach ($this->version->changelog as $item):
			if (empty($item['title']) && empty($item['description'])) continue;
			?>
			<div class="item">
				<?php if (!empty($item['title'])): ?>
					<h2><?php echo $item['title']; ?></h2>
				<?php endif; ?>
				<?php if (!empty($item['description'])): ?>
					<div class="description"><?php echo $item['description']; ?></div>
				<?php endif; ?>
			</div>
			<hr>
		<?php endforeach; ?>
	</div>
</div>