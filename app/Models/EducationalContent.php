<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationalContent extends Model
{
    use HasFactory;

    // CORRECCIÓN: Nombre de tabla
    protected $table = 'educational_content';

    protected $fillable = [
        'post_id',
        'difficulty_level',
        'estimated_read_time',
        'learning_objectives',
        'related_topics',
        'ai_generated',
        'knowledge_area',
        'historical_period',
        'cultural_significance'
    ];

    protected $casts = [
        'estimated_read_time' => 'integer',
        'learning_objectives' => 'array',
        'related_topics' => 'array',
        'ai_generated' => 'boolean',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public static function getDifficultyLevels(): array
    {
        return [
            'beginner' => '👶 Principiante',
            'intermediate' => '🎓 Intermedio', 
            'advanced' => '🧠 Avanzado',
        ];
    }

    public function getDifficultyNameAttribute(): string
    {
        return self::getDifficultyLevels()[$this->difficulty_level] ?? $this->difficulty_level;
    }

    public function isBeginner(): bool
    {
        return $this->difficulty_level === 'beginner';
    }

    public function isIntermediate(): bool
    {
        return $this->difficulty_level === 'intermediate';
    }

    public function isAdvanced(): bool
    {
        return $this->difficulty_level === 'advanced';
    }

    public function hasEstimatedReadTime(): bool
    {
        return !is_null($this->estimated_read_time);
    }

    public function getReadTimeFormattedAttribute(): string
    {
        if (!$this->hasEstimatedReadTime()) {
            return 'Tiempo no especificado';
        }

        if ($this->estimated_read_time < 60) {
            return $this->estimated_read_time . ' min';
        }

        $hours = floor($this->estimated_read_time / 60);
        $minutes = $this->estimated_read_time % 60;

        if ($minutes === 0) {
            return $hours . ' h';
        }

        return $hours . ' h ' . $minutes . ' min';
    }

    public function hasLearningObjectives(): bool
    {
        return !empty($this->learning_objectives) && is_array($this->learning_objectives);
    }

    public function getLearningObjectivesCount(): int
    {
        if (!$this->hasLearningObjectives()) {
            return 0;
        }

        return count($this->learning_objectives);
    }

    public function hasRelatedTopics(): bool
    {
        return !empty($this->related_topics) && is_array($this->related_topics);
    }

    public function isAiGenerated(): bool
    {
        return $this->ai_generated;
    }

    public function hasKnowledgeArea(): bool
    {
        return !empty($this->knowledge_area);
    }

    public function hasHistoricalPeriod(): bool
    {
        return !empty($this->historical_period);
    }

    public function hasCulturalSignificance(): bool
    {
        return !empty($this->cultural_significance);
    }

    public function addLearningObjective(string $objective): void
    {
        $objectives = $this->learning_objectives ?? [];
        $objectives[] = $objective;
        
        $this->update(['learning_objectives' => $objectives]);
    }

    public function addRelatedTopic(string $topic): void
    {
        $topics = $this->related_topics ?? [];
        $topics[] = $topic;
        
        $this->update(['related_topics' => $topics]);
    }

    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    public function scopeBeginner($query)
    {
        return $this->scopeByDifficulty($query, 'beginner');
    }

    public function scopeIntermediate($query)
    {
        return $this->scopeByDifficulty($query, 'intermediate');
    }

    public function scopeAdvanced($query)
    {
        return $this->scopeByDifficulty($query, 'advanced');
    }

    public function scopeWithReadTime($query, int $minMinutes = 1)
    {
        return $query->where('estimated_read_time', '>=', $minMinutes);
    }

    public function scopeQuickReads($query)
    {
        return $query->where('estimated_read_time', '<=', 10);
    }

    public function scopeInDepth($query)
    {
        return $query->where('estimated_read_time', '>=', 30);
    }

    public function scopeByKnowledgeArea($query, string $area)
    {
        return $query->where('knowledge_area', $area);
    }

    public function scopeByHistoricalPeriod($query, string $period)
    {
        return $query->where('historical_period', $period);
    }

    public function scopeAiGenerated($query)
    {
        return $query->where('ai_generated', true);
    }

    public function scopeHumanGenerated($query)
    {
        return $query->where('ai_generated', false);
    }

    public static function getKnowledgeAreas(): array
    {
        return [
            'history' => '📜 Historia',
            'art' => '🎨 Arte',
            'culture' => '🏛️ Cultura',
            'traditions' => '🎭 Tradiciones',
            'architecture' => '🏛️ Arquitectura',
            'gastronomy' => '🍲 Gastronomía',
            'music' => '🎵 Música',
            'literature' => '📚 Literatura',
        ];
    }

    public static function getHistoricalPeriods(): array
    {
        return [
            'pre_columbian' => '⏳ Precolombino',
            'colonial' => '🏰 Colonial',
            'independence' => '⚔️ Independencia',
            'republic' => '🇨🇴 República',
            'modern' => '🏙️ Moderno',
            'contemporary' => '🕰️ Contemporáneo',
        ];
    }

    public function getKnowledgeAreaNameAttribute(): string
    {
        return self::getKnowledgeAreas()[$this->knowledge_area] ?? $this->knowledge_area;
    }

    public function getHistoricalPeriodNameAttribute(): string
    {
        return self::getHistoricalPeriods()[$this->historical_period] ?? $this->historical_period;
    }
}