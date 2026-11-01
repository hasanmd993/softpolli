import DOMPurify from 'dompurify';

/**
 * Safely sanitize an HTML string to prevent XSS attacks while preserving formatting.
 *
 * @param {string|null} dirtyHtml
 * @returns {string}
 */
export function sanitizeHtml(dirtyHtml) {
  if (!dirtyHtml || typeof dirtyHtml !== 'string') {
    return '';
  }

  return DOMPurify.sanitize(dirtyHtml, {
    ALLOWED_TAGS: [
      'p', 'b', 'i', 'em', 'strong', 'strike', 's', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
      'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'br', 'hr', 'a', 'span'
    ],
    ALLOWED_ATTR: ['href', 'title', 'target', 'rel', 'class'],
  });
}
