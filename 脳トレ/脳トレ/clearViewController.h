//
//  clearViewController.h
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <AVFoundation/AVFoundation.h>

int timerCount; //1秒ごとにカウントする
NSTimer *timer; //1秒をはかる
UIImageView *starImageView[10];

@interface clearViewController : UIViewController{
    __weak IBOutlet UILabel *clearTimeCountLabel;
    __weak IBOutlet UILabel *correctCountLabel;
    __weak IBOutlet UILabel *inCorrectCountLabel;
    __weak IBOutlet UIImageView *backgroundImageView;
}
@property int clearTimeCount;       //渡されるポイント(変数名ミスった)
@property int clearCorrectCount;    //渡される正解数
@property int clearInCorrectCount;  //渡される不正解数
@property int maxPoint;             //渡される最大ポイント
@property BOOL seOnOff;             //渡されるサウンドオンオフフラグ

- (void)timerAction;

@end
