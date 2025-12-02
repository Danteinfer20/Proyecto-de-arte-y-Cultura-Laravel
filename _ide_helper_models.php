<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUserId($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AiRecommendation
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $recommended_post_id
 * @property string|null $recommendation_type
 * @property string|null $confidence_score
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $confidence_label
 * @property-read string $confidence_level
 * @property-read int $confidence_percentage
 * @property-read string $personalized_message
 * @property-read string $recommendation_type_name
 * @property-read string $truncated_reason
 * @property-read \App\Models\Post|null $recommendedPost
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation byUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation cultural()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation educational()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation events()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation highConfidence()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation mediumConfidence()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation products()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation recent(int $days = 7)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereConfidenceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereRecommendationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereRecommendedPostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiRecommendation withReason()
 */
	class AiRecommendation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $color
 * @property string $slug
 * @property bool $is_active
 * @property int $sort_order
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read string $full_path
 * @property-read int $total_posts_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category active()
 * @method static \Illuminate\Database\Eloquent\Builder|Category art()
 * @method static \Illuminate\Database\Eloquent\Builder|Category byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Category educational()
 * @method static \Illuminate\Database\Eloquent\Builder|Category event()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Category product()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category root()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withChildren()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $content
 * @property int $like_count
 * @property bool $is_edited
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Comment|null $parent
 * @property-read \App\Models\Post $post
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment popular()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment recent()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment replies()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment rootComments()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereIsEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereLikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withLikes($minLikes = 1)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContentType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $allows_events
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $usage_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType active()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType allowsEducation()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType allowsEvents()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType forEducation()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType forEvents()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType popular()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereAllowsEvents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereUpdatedAt($value)
 */
	class ContentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EducationalContent
 *
 * @property int $id
 * @property int $post_id
 * @property string $difficulty_level
 * @property int|null $estimated_read_time
 * @property array|null $learning_objectives
 * @property array|null $related_topics
 * @property bool $ai_generated
 * @property string|null $knowledge_area
 * @property string|null $historical_period
 * @property string|null $cultural_significance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $difficulty_name
 * @property-read string $historical_period_name
 * @property-read string $knowledge_area_name
 * @property-read string $read_time_formatted
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent advanced()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent aiGenerated()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent beginner()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent byDifficulty(string $difficulty)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent byHistoricalPeriod(string $period)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent byKnowledgeArea(string $area)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent humanGenerated()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent inDepth()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent intermediate()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent quickReads()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereAiGenerated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereCulturalSignificance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereDifficultyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereEstimatedReadTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereHistoricalPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereKnowledgeArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereLearningObjectives($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereRelatedTopics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalContent withReadTime(int $minMinutes = 1)
 */
	class EducationalContent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $post_id
 * @property int|null $location_id
 * @property int $organizer_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $price
 * @property int|null $max_capacity
 * @property int|null $available_slots
 * @property bool $requires_rsvp
 * @property string $event_type
 * @property string $event_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventAttendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User $organizer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PerformingArt> $performingArts
 * @property-read int|null $performing_arts_count
 * @property-read \App\Models\Post $post
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event free()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event ongoing()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event requiresRsvp()
 * @method static \Illuminate\Database\Eloquent\Builder|Event upcoming()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAvailableSlots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMaxCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRequiresRsvp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventAttendance
 *
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property string $status
 * @property int $guest_count
 * @property string|null $qr_code
 * @property bool $checked_in
 * @property \Illuminate\Support\Carbon|null $checked_in_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereCheckedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereCheckedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereGuestCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendance whereUserId($value)
 */
	class EventAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Follow
 *
 * @property int $id
 * @property int $follower_id
 * @property int $followed_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $follower
 * @property-read \App\Models\User|null $following
 * @method static \Illuminate\Database\Eloquent\Builder|Follow followers($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow following($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Follow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string|null $neighborhood
 * @property string $city
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $location_type
 * @property string|null $phone
 * @property string|null $opening_hours
 * @property string|null $description
 * @property string|null $photo
 * @property string|null $website
 * @property int|null $capacity
 * @property bool $is_accessible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read array $coordinates
 * @property-read string $full_address
 * @property-read string $location_type_name
 * @method static \Illuminate\Database\Eloquent\Builder|Location accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Location byType(string $type)
 * @method static \Database\Factories\LocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Location inPopayan()
 * @method static \Illuminate\Database\Eloquent\Builder|Location nearby(float $latitude, float $longitude, int $radiusKm = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereIsAccessible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereOpeningHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location withCapacity(int $minCapacity = 1)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $title
 * @property string $message
 * @property string|null $action_url
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $excerpt
 * @property-read string $icon
 * @property-read string $time_ago
 * @property-read string $type_name
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notification byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification byUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification comments()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification events()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification followers()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification reactions()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification read()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification recent(int $hours = 24)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification withAction()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $items_count
 * @property-read string $payment_method_name
 * @property-read string $status_name
 * @property-read int $unique_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order byStatus(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Order cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Order confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order delivered()
 * @method static \Illuminate\Database\Eloquent\Builder|Order forUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order recent(int $days = 7)
 * @method static \Illuminate\Database\Eloquent\Builder|Order shipped()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withHighValue(float $minAmount = '100000')
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PasswordResetToken
 *
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken query()
 * @mixin \Eloquent
 */
	class PasswordResetToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PerformingArt
 *
 * @property int $id
 * @property int $event_id
 * @property string $art_type
 * @property int|null $duration_minutes
 * @property string|null $artistic_director
 * @property string|null $company
 * @property string|null $genre
 * @property string|null $target_audience
 * @property string|null $technical_requirements
 * @property array|null $cast_members
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read string $art_type_name
 * @property-read string $duration_formatted
 * @property-read string $target_audience_name
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt byArtType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt circus()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt dance()
 * @method static \Database\Factories\PerformingArtFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt forTargetAudience(string $audience)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt longPerformances()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt music()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt query()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt shortPerformances()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt theater()
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereArtType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereArtisticDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereCastMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereTargetAudience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereTechnicalRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PerformingArt withTechnicalRequirements()
 */
	class PerformingArt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PersonalAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property string|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $category_id
 * @property int $content_type_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $excerpt
 * @property string|null $featured_image
 * @property string $status
 * @property bool $is_featured
 * @property bool $allow_comments
 * @property int $view_count
 * @property int $share_count
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\ContentType $contentType
 * @property-read \App\Models\Event|null $event
 * @property-read string|null $featured_image_url
 * @property-read string|null $main_image
 * @property-read string $safe_excerpt
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMedia> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
 * @property-read int|null $reactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SavedItem> $savedItems
 * @property-read int|null $saved_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post byCategory($categoryId)
 * @method static \Illuminate\Database\Eloquent\Builder|Post byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Post educational()
 * @method static \Illuminate\Database\Eloquent\Builder|Post featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAllowComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereShareCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViewCount($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostMedia
 *
 * @property int $id
 * @property int $post_id
 * @property string $media_path
 * @property string $media_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $file_base_name
 * @property-read mixed $file_url
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereMediaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PostMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $category_id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property string|null $sale_price
 * @property int $stock_quantity
 * @property string $product_type
 * @property string|null $dimensions
 * @property string|null $materials
 * @property string|null $weight_kg
 * @property string|null $main_image
 * @property string $status
 * @property bool $is_featured
 * @property int $sales_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read string $status_name
 * @property-read string $type_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Product available()
 * @method static \Illuminate\Database\Eloquent\Builder|Product byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Product digital()
 * @method static \Illuminate\Database\Eloquent\Builder|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Product handicrafts()
 * @method static \Illuminate\Database\Eloquent\Builder|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder|Product lowStock(int $threshold = 5)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product onSale()
 * @method static \Illuminate\Database\Eloquent\Builder|Product physical()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product services()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaterials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeightKg($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $display_alt_text
 * @property-read string $image_url
 * @property-read int $sort_order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage byProduct(int $productId)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage primary()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage secondary()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedAt($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reaction
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $reaction_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $emoji
 * @property-read string $icon
 * @property-read string $type_name
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction byUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction forPost(int $postId)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction inspires()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction interests()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction likes()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction loves()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction ofType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereReactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUserId($value)
 */
	class Reaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SavedItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $category_icon
 * @property-read string $category_name
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem byCategory(string $category)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem byUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem educational()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem favorites()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem forPost(int $postId)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem inspiration()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem readLater()
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavedItem whereUserId($value)
 */
	class SavedItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $display_color
 * @property-read string $popularity
 * @property-read string $tag_type_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag art()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag educational()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag eras()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag places()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag popular(int $minUsage = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag recent(int $days = 30)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag search(string $search)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag techniques()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag trending()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $user_type
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $gender
 * @property string|null $phone
 * @property string $city
 * @property string|null $neighborhood
 * @property string|null $bio
 * @property string|null $profile_picture
 * @property string|null $cover_picture
 * @property string|null $website
 * @property array|null $social_media
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string $status
 * @property bool $is_verified
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventAttendance> $eventAttendance
 * @property-read int|null $event_attendance_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read int|null $age
 * @property-read string $avatar_url
 * @property-read string $display_name
 * @property-read string $user_type_formatted
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PerformingArt> $performingArts
 * @property-read int|null $performing_arts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
 * @property-read int|null $reactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SavedItem> $savedItems
 * @property-read int|null $saved_items_count
 * @property-read \App\Models\UserSetting|null $userSettings
 * @property-read \App\Models\UserStatistic|null $userStatistics
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User artists()
 * @method static \Illuminate\Database\Eloquent\Builder|User culturalManagers()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User visitors()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCoverPicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsite($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property bool $email_notifications
 * @property bool $push_notifications
 * @property bool $new_followers_notify
 * @property bool $comments_notify
 * @property bool $nearby_events_notify
 * @property bool $public_profile
 * @property string $language
 * @property string $theme
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $language_name
 * @property-read string $theme_name
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting byLanguage(string $language)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting byTheme(string $theme)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting publicProfiles()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereCommentsNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereEmailNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereNearbyEventsNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereNewFollowersNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting wherePublicProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting wherePushNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting withEmailNotifications()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting withPushNotifications()
 */
	class UserSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserStatistic
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_count
 * @property int $follower_count
 * @property int $following_count
 * @property int $event_count
 * @property int $attendance_count
 * @property string $average_rating
 * @property int $sales_count
 * @property string $total_revenue
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $activity_level
 * @property-read float $popularity_score
 * @property-read float|null $success_rate
 * @property-read int $total_engagement
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic active()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic contentCreators()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic educationalContributors()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic eventOrganizers()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic popular()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic sellers()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereAttendanceCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereEventCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereFollowerCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereFollowingCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic wherePostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereSalesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereTotalRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatistic withHighRevenue(float $minRevenue = '100000')
 */
	class UserStatistic extends \Eloquent {}
}

