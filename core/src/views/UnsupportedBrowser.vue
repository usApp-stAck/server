 <!--
  - @copyright Copyright (c) 2021 John Molakvoæ <skjnldsv@protonmail.com>
  -
  - @author John Molakvoæ <skjnldsv@protonmail.com>
  -
  - @license GNU AGPL version 3 or any later version
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program.  If not, see <http://www.gnu.org/licenses/>.
  -
  -->
<template>
	<Content app-name="unsupported-browser" class="content-unsupported-browser">
		<EmptyContent icon="icon-error">
			{{ t('core', 'This browser is not supported') }}
			<template #desc>
				{{ t('core', 'Please upgrade to a more recent browser') }}
			</template>
		</EmptyContent>
	</Content>
</template>

<script>
import Content from '@nextcloud/vue/dist/Components/Content'
import EmptyContent from '@nextcloud/vue/dist/Components/EmptyContent'
import { translate as t, translatePlural as n } from '@nextcloud/l10n'

export default {
	name: 'UnsupportedBrowser',
	components: {
		Content,
		EmptyContent,
	},
	methods: {
		t,
		n,
	},
}
</script>

<style lang="scss">
.content-unsupported-browser {
	display: flex;
	width: 100%;
	justify-content: center;
}
</style>
