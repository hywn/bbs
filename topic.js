const ID = new URLSearchParams(location.search).get('id') || 'main'

document.querySelector('title').setAttribute('value', ID)

const parts = ID.split('.')

document.querySelector('h1').innerHTML = `viewing ${
	parts.map((name, i) => `<a href="?id=${parts.slice(0, i + 1).join('.')}">${name}</a>`).join('.')
}`

const [parent, child] = parts.length >= 2
	? [parts.slice(0, parts.length - 1).join('.'), +parts[parts.length - 1]]
	: [ID, null]

const display_content =
	content =>
		content
			.replace(/\n/g, '<br/>')
			.replace(/\!\[.*?\]\((.+?)\)/g, '<img src="$1"/>')

const display =
	post => `
		<div class='post'>
			${post.id}: (display date here) <a href="?id=${post.parent}.${post.id}">[view/reply]</a>
			<blockquote>${display_content(post.comment)}</blockquote>
			${post.children.map(display).join('')}
		</div>
	`

const display_posts =
	async () =>
{
	const posts = await fetch(`./get_posts.php?pid=${parent}`)
		.then(r => r.json())
		.then(j => child
			? j.filter(({ id }) => id === child)
			: j
		)

	document.querySelector('#posts').innerHTML = `<dl>${posts.map(display).join('')}</dl>`
}

display_posts()

const SUBMIT_BUTTON = document.querySelector('#submit_button')
const CONTENT_FIELD = document.querySelector('#content')

SUBMIT_BUTTON.addEventListener('click', e => {
	const text = CONTENT_FIELD.value

	fetch(`./submit.php`, { method: 'post', body: new URLSearchParams({ pid: ID, comment: text }) })
		.then(r => {})
		.then(display_posts)

	CONTENT_FIELD.value = ''
})